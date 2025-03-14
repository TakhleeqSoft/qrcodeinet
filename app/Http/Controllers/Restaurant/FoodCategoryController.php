<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\File;
use App\Http\Requests\Restaurant\FoodCategoryRequest;
use App\Models\Food;
use App\Repositories\Restaurant\FoodCategoryRepository;
use Illuminate\Http\UploadedFile;

class FoodCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show category')->only('index','show');
        $this->middleware('permission:add category')->only('create','store');
        $this->middleware('permission:edit category')->only('edit','update');
        $this->middleware('permission:delete category')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'restaurant_id');
        $params['restaurant_id'] = $user->restaurant_id??0;
        $foodCategories = (new FoodCategoryRepository)->getRestaurantFoodCategories($params);
        return view('restaurant.food_categories.index', ['foodCategories' => $foodCategories,'restaurant_id'=>$params['restaurant_id']]);
    }

    public function create()
    {
        $user = auth()->user();
        if($user->restaurant_id==null){
            return redirect('restaurants')->with(['Error' => __('system.dashboard.create_restro')]);
        }
        return view('restaurant.food_categories.create');
    }

    public function store(FoodCategoryRequest $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $input = $request->only('category_name', 'restaurant', 'restaurant_id', 'category_image', 'lang_category_name');
            $input['sort_order'] = FoodCategory::max('sort_order') + 1;
            FoodCategory::create($input);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.food_categories.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('restaurant.food_categories.index');
    }

    public function show(FoodCategory $foodCategory)
    {
    }

    public function checkRestaurantIsValidFoodCategory($food_category_id, $user = null)
    {

        if (empty($user)) {
            $user = auth()->user();
        }

        $user->load(['restaurant.food_categories' => function ($q) use ($food_category_id) {
            $q->where('id', $food_category_id);
        }]);

        if (!isset($user->restaurant) || count($user->restaurant->food_categories) == 0) {
            $back = request()->get('back', route('restaurant.food_categories.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.food_categories.title')]));

            return $back;
        }
    }

    public function edit(FoodCategory $foodCategory)
    {
        if (($redirect = $this->checkRestaurantIsValidFoodCategory($foodCategory->id)) != null) {
            return redirect($redirect);
        }
        return view('restaurant.food_categories.edit', ['foodCategory' => $foodCategory]);
    }

    public function update(FoodCategoryRequest $request, FoodCategory $foodCategory)
    {

        if (($redirect = $this->checkRestaurantIsValidFoodCategory($foodCategory->id)) != null) {
            return redirect($redirect);
        }
        $input = $request->only('category_name', 'category_image', 'lang_category_name');
        $foodCategory->fill($input)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.food_categories.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('restaurant.food_categories.index'));
    }

    public function destroy(FoodCategory $foodCategory)
    {
        $request = request();
        if (($redirect = $this->checkRestaurantIsValidFoodCategory($foodCategory->id)) != null) {
            return redirect($redirect);
        }
        $foodCategory->load('foods');
        $foods = $foodCategory->foods;
        $foodCategory->delete();
        $foods->loadCount('food_categories');
        foreach ($foods as $food) {
            if ($food->food_categories_count == 0) {
                $food->delete();
            }
        }
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.food_categories.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('restaurant.food_categories.index'));
    }

    public function positionChange()
    {
        $request = request();
        $foodCategory = FoodCategory::where('id', $request->id)->update(['sort_order' => $request->index]);
        return true;
    }


    public static function getCurrentRestaurantAllFoodCategories()
    {
        $user = request()->user();

        $user->load(['restaurant.food_categories' => function ($q) {
            $q->orderBy('category_name', 'asc');
        }]);

        if($user->restaurant!=null){
            $food_categories = $user->restaurant->food_categories->mapWithKeys(function ($food_category, $key) {
                return [$food_category->id => $food_category->category_name];
            });
            return ['' => __('system.fields.select_Category')] + $food_categories->toarray();
        }

        return ['' => __('system.fields.select_Category')];
    }
    public function availableIconUpdate(Request $request)
    {
        // Validate the request to ensure 'icon_available' is provided and is a boolean
        $validator = Validator::make($request->all(), [
            'icon_available' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Using HTTP status code 422 for validation errors
        }

        // Attempt to update all records within a transaction for safety
        DB::beginTransaction();
        try {
            FoodCategory::query()->where('restaurant_id',$request->restaurant_id)->update([
                'icon_available' => $request->icon_available
            ]);
            DB::commit(); // Commit the changes if no exception was thrown

            return response()->json(['message' => 'Icon availability updated successfully for all categories!'], 200);
        } catch (\Exception $exception) {
            DB::rollback(); // Rollback the transaction on error
            return response()->json(['error' => 'Failed to update icon availability due to an error.'], 500);
        }
    }
}
