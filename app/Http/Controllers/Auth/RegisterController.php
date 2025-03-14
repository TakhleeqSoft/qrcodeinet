<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\VendorSetting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        $lbl_restaurant_name = strtolower(__('system.fields.restaurant_name'));
        $lbl_restaurant_type = strtolower(__('system.fields.restaurant_type'));
        $lbl_phone_number = strtolower(__('system.fields.phone_number'));
        $lbl_first_name = strtolower(__('system.fields.first_name'));
        $lbl_last_name = strtolower(__('system.fields.last_name'));
        $lbl_email = strtolower(__('system.fields.email'));
        $lbl_password = strtolower(__('system.fields.password'));

        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required','unique:users,phone_number'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            "first_name.required" => __('validation.required', ['attribute' => $lbl_first_name]),
            "first_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_first_name]),

            "last_name.required" => __('validation.required', ['attribute' => $lbl_last_name]),
            "last_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_last_name]),

            "phone_number.required" => __('validation.required', ['attribute' => $lbl_phone_number]),
            "phone_number.regex" => __('validation.custom.invalid', ['attribute' => $lbl_phone_number]),
            "phone_number.unique" => __('validation.unique', ['attribute' => $lbl_phone_number]),

            "email.required" => __('validation.required', ['attribute' => $lbl_email]),
            "email.string" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "email.email" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "email.unique" => __('validation.unique', ['attribute' => $lbl_email]),

            "password.required" => __('validation.required', ['attribute' => $lbl_password]),
            "password.string" => __('validation.password.invalid', ['attribute' => $lbl_password]),
            "password.regex" => __('validation.password.invalid', ['attribute' => $lbl_password]),
        ]);
    }

    protected function create(array $data)
    {
        $days = config('app.trial_days');
        $trial_expire_at = \Carbon\Carbon::now()->addDays($days)->format("Y-m-d H:i:s");
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'status' => User::STATUS_ACTIVE,
            'trial_expire_at' => $trial_expire_at,
            'user_type' => User::USER_TYPE_VENDOR,
            'is_trial_enabled' => true,
        ]);

        VendorSetting::updateOrCreate([
            'user_id'=>$user->id
        ],[]);

        $user->assignRole("vendor");

        $vendorPlan = new Subscriptions();
        $vendorPlan->user_id = $user->id;
        $vendorPlan->plan_id = 0;
        $vendorPlan->start_date = now();
        $vendorPlan->expiry_date = $trial_expire_at;
        $vendorPlan->is_current = 'yes';
        $vendorPlan->payment_method = 'Trial';
        $vendorPlan->amount = 0;
        $vendorPlan->type = "trial";
        $vendorPlan->table_limit = 0;
        $vendorPlan->restaurant_limit = config('app.trial_restaurant');
        $vendorPlan->item_limit = config('app.trial_food');
        $vendorPlan->staff_limit = config('app.trial_staff');
        $vendorPlan->item_unlimited = "no";
        $vendorPlan->table_unlimited = "no";
        $vendorPlan->restaurant_unlimited = "no";
        $vendorPlan->staff_unlimited = "no";
        $vendorPlan->status = 'approved';
        $vendorPlan->details = "Vendor Trial";
        $vendorPlan->save();



        return $user;
    }

    public function slugCheck()
    {
        $var = request()->val;
        $exist = Restaurant::where('slug', $var)->count();
        if ($exist > 0) {
            return ['exist' => true, 'message' => __('system.messages.slug_already_exist')];
        } else {
            return ['exist' => false];
        }
    }
}
