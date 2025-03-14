<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Restaurant;
use App\Models\VendorSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\FoodRequest;
use App\Models\Food;
use App\Models\User;
use App\Models\RestaurantSettings;
use App\Repositories\Restaurant\FoodRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
 
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Jobs\ProcessImageJob;
use Illuminate\Support\Facades\Storage;



class FoodController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show food')->only('index','show');
        $this->middleware('permission:add food')->only('create','store');
        $this->middleware('permission:edit food')->only('edit','update');
        $this->middleware('permission:delete food')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();

        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'food_category_id');
        $params['restaurant_id'] = $user->restaurant_id ?? 0;
        $foods = (new FoodRepository())->getUserRestaurantFoods($params);
        return view('restaurant.foods.index', ['foods' => $foods]);
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->restaurant_id == null) {
            return redirect('restaurants')->with(['Error' => __('system.dashboard.create_restro')]);
        }

        $vendor_id = ($user->user_type == 2) ? $user->created_by : $user->id;

        if ($this->checkPlan($user) == false) {

            if ($user->user_type == User::USER_TYPE_STAFF) {
                return redirect()->route('home')->with(['Error' => __('system.plans.item_extends')]);
            }

            return redirect()->route('restaurant.vendor.plan')->with(['Error' => __('system.plans.item_extends')]);
        }

        $vendor = User::find($vendor_id);
        $vendor_setting = RestaurantSettings::where('restaurant_id', $user->restaurant_id)->first();
        return view('restaurant.foods.create', compact('vendor', 'vendor_setting'));
    }

    public function store(FoodRequest $request)
    {
        
        $user = auth()->user();
        if ($this->checkPlan($user) == false) {
            return redirect()->route('restaurant.vendor.plan')->with(['Error' => __('system.plans.item_extends')]);
        }

        DB::beginTransaction();
        $input = $request->all();

        if (empty($input['discount_type'])) {
            $input['discount_type'] = null;
            $input['discount_price'] = null;
        }

      
    
// ضغط وحفظ صورة الفئة إذا تم رفعها
if ($request->hasFile('food_image')) {
    $file = $request->file('food_image');
    $imagePath = 'food_image/' . pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';

    // ضغط الصورة وحفظها بصيغة WebP
    $image = Image::make($file)
        ->resize(1500, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->encode('webp', 50);

    Storage::disk('public')->put($imagePath, (string) $image);
    $input['food_image'] = $imagePath;
}

// ضغط وحفظ الأيقونة إذا تم رفعها
if ($request->hasFile('icon')) {
    $iconFile = $request->file('icon');
    $iconPath = 'food_image/' . pathinfo($iconFile->hashName(), PATHINFO_FILENAME) . '_icon.webp';

    // ضغط الأيقونة وحفظها بصيغة WebP
    $icon = Image::make($iconFile)
        ->resize(150, 150)
        ->encode('webp', 50);

    Storage::disk('public')->put($iconPath, (string) $icon);
    $input['icon'] = $iconPath;
}
        if ($request->is_default_image == 'on') {
            $input['is_default_image'] = true;
        }

        createQniqueSessionAndDestoryOld('unique', 1);
        $categories = $request->categories;

        $food = Food::create($input);
        $inserts = [];
        foreach ($categories as $category) {
            $max = DB::table('food_food_category')->where('food_category_id', $category)->max('sort_order') + 1;
            $inserts[] = ['food_category_id' => $category, 'food_id' => $food->id, 'sort_order' => $max];
        }

        DB::table('food_food_category')->insert($inserts);
        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.foods.title')]));

        DB::commit();
        return redirect()->route('restaurant.foods.index');
    }

    public function show(food $food)
    {
        if (($redirect = $this->checkRestaurantIsValidFood($food)) != null) {

            return redirect($redirect);
        }
        return view('restaurant.foods.view', ['food' => $food]);
    }

    public function edit(food $food)
    {
        $user = auth()->user();
        $vendor_id = ($user->user_type == 2) ? $user->created_by : $user->id;

        if (($redirect = $this->checkRestaurantIsValidFood($food)) != null) {
            return redirect($redirect);
        }
        $vendor = User::find($vendor_id);
        $vendor_setting = RestaurantSettings::where('restaurant_id', $user->restaurant_id)->first();

        return view('restaurant.foods.edit', ['food' => $food, 'vendor' => $vendor, 'vendor_setting' => $vendor_setting]);
    }

    protected function checkPlan($user)
    {
        $userPlan = isset($user->current_plans[0]) ? $user->current_plans[0] : '';
        if ($user->user_type==User::USER_TYPE_STAFF) {
            $owner=User::find($user->created_by);
            $userPlan = isset($owner->current_plans[0]) ? $owner->current_plans[0] : '';
        }

        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;

        $userFoods = Food::whereHas('restaurant', function ($q) use ($vendor_id) {
            $q->where('user_id', $vendor_id);
        })->count();

        if ($user->user_type != User::USER_TYPE_ADMIN && $userPlan && $user->free_forever != true) {

            if ((!$userPlan || $userFoods >= $userPlan->item_limit) && $userPlan->item_unlimited != 'yes') {
                return false;
            }
        } else if ($user->user_type != User::USER_TYPE_ADMIN && !$userPlan) {
            return false;
        }
        return true;
    }

    public function checkRestaurantIsValidFood($food)
    {
        $user = auth()->user();
        $params['restaurant_id'] = $user->restaurant_id;
        $params['id'] = $food->id;

        $food = (new FoodRepository())->getUserRestaurantFood($params);
        if (empty($food)) {
            $back = request()->get('back', route('restaurant.foods.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.foods.title')]));

            return $back;
        }
    }

    public function update(FoodRequest $request, food $food)
{
    if (($redirect = $this->checkRestaurantIsValidFood($food)) != null) {
        return redirect($redirect);
    }

    $categories = $request->categories;
    $data = $request->only('restaurant_id', 'calories', 'lang_calories', 'lang_allergy', 'allergy', 'food_category_id', 'name', 'description', 'price', 'preparation_time', 'is_featured', 'is_available', 'is_out_of_sold', 'ingredient', 'food_image', 'label_image', 'lang_name', 'lang_description', 'gallery_image', 'key', 'val', 'discount_type', 'discount_price');

    // ضغط وحفظ صورة الطعام إذا تم رفعها
    if ($request->hasFile('food_image')) {
        // مسار الصورة الحالية للطعام
        $currentFoodImagePath = $food->food_image;

        // حذف الصورة الحالية إذا كانت موجودة
        if ($currentFoodImagePath && Storage::disk('public')->exists($currentFoodImagePath)) {
            Storage::disk('public')->delete($currentFoodImagePath);
            \Log::info('تم حذف صورة الطعام الحالية بنجاح من المسار: ' . $currentFoodImagePath);
        } else {
            \Log::warning('فشل في العثور على صورة الطعام الحالية أو حذفها من المسار: ' . $currentFoodImagePath);
        }

        // حفظ الصورة الجديدة
        $file = $request->file('food_image');
        $imagePath = 'food_image/' . pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';

        $img = Image::make($file->getRealPath());
        $img->resize(1500, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->encode('webp', 50)->save(storage_path('app/public/' . $imagePath));

        $data['food_image'] = $imagePath;
    }

    // ضغط وحفظ الأيقونة إذا تم رفعها
    if ($request->hasFile('icon')) {
        // مسار الأيقونة الحالية
        $currentIconPath = $food->icon;

        // حذف الأيقونة الحالية إذا كانت موجودة
        if ($currentIconPath && Storage::disk('public')->exists($currentIconPath)) {
            Storage::disk('public')->delete($currentIconPath);
            \Log::info('تم حذف الأيقونة الحالية بنجاح من المسار: ' . $currentIconPath);
        } else {
            \Log::warning('فشل في العثور على الأيقونة الحالية أو حذفها من المسار: ' . $currentIconPath);
        }

        // حفظ الأيقونة الجديدة
        $iconFile = $request->file('icon');
        $iconPath = 'food_image/' . pathinfo($iconFile->hashName(), PATHINFO_FILENAME) . '.webp';

        $iconImg = Image::make($iconFile->getRealPath());
        $iconImg->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $iconImg->encode('webp', 50)->save(storage_path('app/public/' . $iconPath));

        $data['icon'] = $iconPath;
    }

    if (empty($data['discount_type'])) {
        $data['discount_type'] = null;
        $data['discount_price'] = null;
    }

    $data['is_default_image'] = false;
    if ($request->is_default_image == 'on') {
        $data['is_default_image'] = true;
    }

    createQniqueSessionAndDestoryOld('unique', 1);

    $addData = array_diff($categories, $food->categories_ids);
    $deleted = array_diff($food->categories_ids, $categories);

    $food->fill($data)->save();
    DB::table('food_food_category')->where('food_id', $food->id)->whereIn('food_category_id', $deleted)->delete();

    $inserts = [];
    foreach ($addData as $category) {
        $inserts[] = ['food_category_id' => $category, 'food_id' => $food->id];
    }
    DB::table('food_food_category')->insert($inserts);

    $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.foods.title')]));

    if ($request->back) {
        return redirect($request->back);
    }
    return redirect(route('restaurant.foods.index'));
}

    public function destroy(food $food)
    {
        $request = request();
        if (($redirect = $this->checkRestaurantIsValidFood($food)) != null) {
            return redirect($redirect);
        }

        $food->delete();

        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.foods.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('restaurant.foods.index'));
    }

    public function positionChange()
    {
        $request = request();

        DB::table('food_food_category')->where('food_id', $request->food_id)->where('food_category_id', $request->category)->update(['sort_order' => $request->index]);
        return true;
    }

    public function uploadImage()
    {
        $request = request();
        $file = $request->file('file');
        $unique = $request->unique;
        $upload_name = uploadFile($file, $unique);
        $name =  basename($upload_name);
        $newFileName = substr($name, 0, (strrpos($name, ".")));
        return ['data' => ['name' => $name, "id" => $newFileName, 'upload_name' => $upload_name]];
    }
}
