<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Feedback;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\RestaurantUser;
use App\Models\Table;
use App\Models\User;
use App\Models\Plans;
use App\Models\Settings;
use App\Models\Restaurant;
use App\Models\UserFeedback;
use App\Models\Waiter;
use Illuminate\Support\Arr;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\VendorSetting;
use App\Models\RestaurantSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Restaurant\UserRequest;
use App\Repositories\Restaurant\UserRepository;
use Intervention\Image\Facades\Image;

class VendorController extends Controller
{
    public function index()
    {
        $request = request();
        $vendor = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = 10;
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;
        $params['user_id'] = $vendor->id;

        $vendors = (new UserRepository())->getRestaurantUsers($params);
        if ($request->user_list ==  'all') {
            $vendors->load('restaurants');
        }

        $plans = Plans::where('status', 'active')->pluck('title', 'plan_id')->toArray();
        return view('restaurant.vendors.index', ['vendors' => $vendors, 'plans' => $plans]);
    }

    public function create()
    {
        $plans = Plans::where('status', 'active')->orderBy('title', 'asc')->get();
        return view('restaurant.vendors.create', compact('plans'));
    }

    public function show(User $vendor)
    {
        if (isset($vendor->user_type) && $vendor->user_type != 3) {
            return back();
        }

        $total_restaurants = Restaurant::where('user_id', $vendor->id)->count();
        $total_staff = User::where('created_by', $vendor->id)->count();

        $current_plans = (isset($vendor->current_plans) && count($vendor->current_plans) > 0) ? $vendor->current_plans[0] : array();

        $plan_id = isset($current_plans->plan_id) ? $current_plans->plan_id : 0;

        $plans = Plans::find($plan_id);

        return view('restaurant.vendors.show', compact('vendor', 'total_staff', 'total_restaurants', 'plans', 'current_plans'));
    }

    public function paymentTransactions($vendor_id)
    {
        $vendor = User::where('id', $vendor_id)->first();
        if (empty($vendor)) {
            abort(404);
        }

        if (auth()->user()->user_type != User::USER_TYPE_ADMIN) {
            return redirect('home');
        }

        $transactions = Transactions::where('user_id', $vendor->id)->with(['subscription' => function($subQuery){
            $subQuery->select('payment_method');
        }])
        ->orderBy('created_at', 'desc')->get();
        return view('restaurant.vendors.payment-transaction', compact('vendor', 'transactions'));
    }

    public function subscriptionHistory($vendor_id)
    {
        $vendor = User::where('id', $vendor_id)->first();
        if (empty($vendor)) {
            abort(404);
        }

        if (auth()->user()->user_type != User::USER_TYPE_ADMIN) {
            return redirect('home');
        }

        $subscriptions = Subscriptions::where('user_id', $vendor_id)->orderBy('created_at', 'desc')->get();
        return view('restaurant.vendors.subscription-transaction', compact('vendor', 'subscriptions'));
    }

    public function store(UserRequest $request)
    {


        $vendor = auth()->user();
        $data = $request->all();

        $plan_id = (int)request()->user_plan;

        $plan = Plans::find($plan_id);

        $free_forever = false;
        if ($plan == null) {
            $free_forever = true;
        }

        $newUser = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'profile_image' => $data['profile_image'] ?? null,
            'password' => Hash::make($data['password']),
            'user_type' => 3,
            'status' => User::STATUS_ACTIVE,
            'created_by' => $vendor->id,
            'email_verified_at' => now(),
            'free_forever' => $free_forever,
            'restaurant_id' => null,
            'address'=>$data['address'],
            'city'=>$data['city'],
            'state'=>$data['state'],
            'country'=>$data['country'],
            'zip'=>$data['zip'],
        ]);
        $newUser->assignRole("vendor");
        $newUser->languages()->sync(1);

        VendorSetting::updateOrCreate([
            'user_id' => $newUser->id
        ], []);

        $expiredDate = null;
        if ($plan != null) {
            if ($plan->type == 'weekly') {
                $expiredDate = now()->addWeek();
            } else if ($plan->type == 'monthly') {
                $expiredDate = now()->addMonth();
            } else if ($plan->type == 'yearly') {
                $expiredDate = now()->addYear();
            } else if ($plan->type == 'day') {
                $expiredDate = now()->addDay();
            }
        }

        $vendorPlan = new Subscriptions();
        $vendorPlan->user_id = $newUser->id;
        $vendorPlan->start_date = now();
        $vendorPlan->expiry_date = $expiredDate;
        $vendorPlan->is_current = 'yes';
        $vendorPlan->payment_method = 'offline';
        $vendorPlan->status = 'approved';
        $vendorPlan->details = "Added By Admin";

        if ($plan == null) {
            $vendorPlan->plan_id = 0;
            $vendorPlan->amount = 0;
            $vendorPlan->type = 'free';
            $vendorPlan->table_limit = 0;
            $vendorPlan->restaurant_limit = 0;
            $vendorPlan->item_limit = 0;
            $vendorPlan->item_unlimited = "yes";
            $vendorPlan->table_unlimited = "yes";
            $vendorPlan->restaurant_unlimited = "yes";
            $vendorPlan->staff_unlimited = "yes";
        } else {
            $vendorPlan->plan_id = $plan->plan_id;
            $vendorPlan->amount = $plan->amount;
            $vendorPlan->type = $plan->type;
            $vendorPlan->table_limit = $plan->table_limit;
            $vendorPlan->restaurant_limit = $plan->restaurant_limit;
            $vendorPlan->item_limit = $plan->item_limit;
            $vendorPlan->staff_limit = $plan->staff_limit;
            $vendorPlan->item_unlimited = $plan->item_unlimited;
            $vendorPlan->table_unlimited = $plan->table_unlimited;
            $vendorPlan->restaurant_unlimited = $plan->restaurant_unlimited;
            $vendorPlan->staff_unlimited = $plan->staff_unlimited;
        }


        $vendorPlan->save();

        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.vendors.title')]));

        return redirect(route('restaurant.vendors.index'));
    }

    public function edit(User $vendor)
    {
        if (isset($vendor->user_type) && $vendor->user_type == 1) {
            return back();
        }

        $plans = Plans::where('status', 'active')->orderBy('title', 'asc')->get();

        return view('restaurant.vendors.edit', ['vendor' => $vendor, 'plans' => $plans]);
    }

    public function update(UserRequest $request, User $vendor)
    {

        if (isset($vendor->user_type) && $vendor->user_type != 3) {
            return back();
        }

        $data = $request->only('first_name', 'email', 'last_name', 'phone_number', 'permission', 'profile_image','address','city','state','country','zip');

        if (empty($vendor->email_verified_at)) {
            $data['email_verified_at'] = now();
        }

        $data['user_type'] = 3;
        $vendor->fill($data)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.vendors.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('restaurant.vendors.index'));
    }


    public function destroy(User $vendor)
    {
        $request = request();
        if (isset($vendor->user_type) && $vendor->user_type != User::USER_TYPE_VENDOR) {
            return back();
        }

        $subscriptions=Subscriptions::where('user_id',$vendor->id)->whereNotNull('subscription_id')->get();

        Subscriptions::where('user_id',$vendor->id)->whereNull('subscription_id')->delete();

        //Delete Vendor Associated Data.
        RestaurantSettings::where('user_id',$vendor->id)->delete();
        RestaurantUser::where('user_id',$vendor->id)->delete();
        VendorSetting::where('user_id',$vendor->id)->delete();
        Feedback::where('user_id',$vendor->id)->delete();
        Table::where('user_id',$vendor->id)->delete();
        Transactions::where('user_id',$vendor->id)->delete();
        Waiter::where('user_id',$vendor->id)->delete();
        User::where('created_by',$vendor->id)->where('user_type',User::USER_TYPE_STAFF)->delete();

        //Delete Restaurant
        $vendor_restaurants=Restaurant::where('user_id',$vendor->id)->get();
        foreach ($vendor_restaurants as $restro){
            Food::where('restaurant_id',$restro->id)->delete();
            FoodCategory::where('restaurant_id',$restro->id)->delete();
            $restro->delete();
        }

        //Get All Subscription
        if (isset($subscriptions) && count($subscriptions)>0){

            $stripe_data = Settings::where('title', 'stripe')->first();
            $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();
            $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

            if (isset($stripe_secret_key) && $stripe_secret_key!=""){
                $stripe = new \Stripe\StripeClient($stripe_secret_key);

                foreach ($subscriptions as $subscription){
                    $result=$stripe->subscriptions->cancel(
                        $subscription->subscription_id,
                        []
                    );
                    if(isset($result->status) && $result->status=='canceled'){
                        $subscription->delete();
                    }
                }
            }

        }

        $vendor->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.vendors.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('restaurant.vendors.index'));
    }

    public function setting()
    {
        $vendor = auth()->user();
        if ($vendor->user_type == 1) {
            return redirect('home');
        }

        $vendor_id = ($vendor->user_type == 2) ? $vendor->created_by : $vendor->id;
        $setting = RestaurantSettings::where('user_id', $vendor_id)->first();
        $vendorSetting = config('vendor_setting');
        return view("restaurant.settings.display", compact('setting', 'vendorSetting'));
    }

   public function settingUpdate(Request $request)
{
    $vendor = auth()->user();
    if ($vendor->user_type != 3) {
        return redirect('home');
    }

    // الحصول على رمز العملة والرمز الخاص بها بناءً على العملة الافتراضية
    $currency = Arr::where(getAllCurrencies(), function ($value, $key) {
        return request()->default_currency == $key;
    });
    $currency = explode('-', array_values($currency)[0]);

    // تحديد قواعد التحقق من الصور بحيث تكون الصورة اختيارية إذا كانت الإعدادات موجودة بالفعل
    $file_validation = [!empty(config('vendor_setting')) ? 'nullable' : 'required', 'max:50000', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,ico'];
    $attributes = $request->validate([
        "default_food_image" => $file_validation,
        "default_category_image" => $file_validation,
        "default_currency" => "required",
        "default_currency_position" => "required",
    ]);

    // تعيين العملة الافتراضية ورمز العملة
    $attributes['default_currency'] = trim($currency[1]);
    $attributes['default_currency_symbol'] = trim($currency[0]);

    $path = 'vendor_settings';

    // معالجة وضغط صورة الطعام الافتراضية إذا كانت موجودة
    if ($request->hasFile('default_food_image')) {
        $file = $request->file('default_food_image');
        // ضغط وتحويل الصورة إلى صيغة WebP بجودة 50%
        $img = Image::make($file->getRealPath())->encode('webp', 50);
        $imagePath = $path . '/' . pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
        // حفظ الصورة في التخزين
        $img->save(storage_path('app/public/' . $imagePath));
        $attributes['default_food_image'] = $imagePath;
    }

    // معالجة وضغط صورة الفئة الافتراضية إذا كانت موجودة
    if ($request->hasFile('default_category_image')) {
        $iconFile = $request->file('default_category_image');
        // ضغط وتحويل الصورة إلى صيغة WebP بجودة 50%
        $iconImg = Image::make($iconFile->getRealPath())->encode('webp', 50);
        $iconPath = $path . '/' . pathinfo($iconFile->hashName(), PATHINFO_FILENAME) . '.webp';
        // حفظ الصورة في التخزين
        $iconImg->save(storage_path('app/public/' . $iconPath));
        $attributes['default_category_image'] = $iconPath;
    }

    // تحديث أو إنشاء إعدادات البائع
    VendorSetting::updateOrCreate(['user_id' => $vendor->id], $attributes);

    // إرسال رسالة نجاح إلى جلسة المستخدم
    $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
    return redirect()->back();
}


    //planDetails



    public function paymentHistory(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }

        $transactions = Transactions::where('user_id', $vendor->id)->orderBy('created_at', 'desc')->get();
        return view("restaurant.vendor_plan.payment_history", compact('transactions'));
    }

    public function updatePassword(Request $request, User $vendor)
    {
        try {

            $this->validate($request, [
                'new_password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'same:new_password']
            ]);

            $vendor->password = Hash::make($request->new_password);
            $vendor->save();

            return back()->with('Success', __('system.messages.change_success_message', ['model' => __('system.fields.password')]));
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }

    public function staffPlan()
    {
        return view("restaurant.vendor_plan.staff");
    }

    public function pusherSetting(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        $setting = RestaurantSettings::where('user_id', $vendor->id)->first();
        $pusher_data = VendorSetting::select('pusher_appid', 'pusher_key', 'pusher_secret', 'pusher_cluster')->where('user_id', $vendor->id)->first();
        return view("restaurant.settings.pusher_notification", compact('pusher_data','setting'));
    }

    public function pusherUpdate(Request $request)
    {
        try {
            $vendor = auth()->user();
            if ($vendor->user_type != User::USER_TYPE_VENDOR) {
                return redirect('home');
            }

            VendorSetting::where('user_id', $vendor->id)->update([
                'pusher_appid' => $request->pusher_appid,
                'pusher_key' => $request->pusher_key,
                'pusher_secret' => $request->pusher_secret,
                'pusher_cluster' => $request->pusher_cluster,
            ]);

            $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
            return back()->with('success', 'Password change successfully');
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }

    public function languagePage()
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        $data = Restaurant::where('user_id', $vendor->id)->first();
        return view('restaurant.settings.language-page')->with(['data' => $data]);
    }

    public function feedback()
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        $restaurant= Restaurant::where('user_id', $vendor->id)->first();
        $feedbacks = UserFeedback::where('restaurant_id',$restaurant->id)->paginate(25);
        return view('restaurant.feedback')->with(['feedbacks' => $feedbacks]);
    }

    public function feedbackDelete(Request $request)
    {
        $exist = UserFeedback::where('id', $request->id)->first();
        if ($exist) {
            $exist->delete();
            $request->session()->flash('Success', __('system.messages.deleted'));
        } else {
            $request->session()->flash('Error', __('system.messages.not_found'));
        }
        return redirect()->back();
    }
    public function languagePageUpdate(Request $request)
    {
        ini_set('max_execution_time', 600);
        ini_set('post_max_size', '100M');
        $this->validate($request,[
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'map_url' => 'nullable|url',
            'snapchat_url' => 'nullable|url',
            'default_video' => 'nullable|file|mimes:mp4,avi,mov,wmv',
        ]);
        $verndorSetting = Restaurant::where('user_id', auth()->user()->id)->first();
        $verndorSetting->facebook_url = $request->facebook_url;
        $verndorSetting->instagram_url = $request->instagram_url;
        $verndorSetting->twitter_url = $request->twitter_url;
        $verndorSetting->tiktok_url = $request->tiktok_url;
        $verndorSetting->map_url = $request->map_url;
        $verndorSetting->snapchat_url = $request->snapchat_url;
        $verndorSetting->button_color = $request->button_color;
        if ($request->hasFile('default_video')) {
            $file = $request->file('default_video');
            $path = 'vendor_settings';
            $videoPath = $path . '/' . pathinfo($file->hashName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('/', $videoPath);
            $verndorSetting->default_video = $videoPath;
        }
        $verndorSetting->save();
        $request->session()->flash('Success', __('custom.Language Page Updated Successfully'));
        return redirect()->back();
    }
    public function support(){
        return view("restaurant.vendor_plan.support");
    }
}
