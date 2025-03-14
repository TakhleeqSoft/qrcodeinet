<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\Settings;
use App\Models\Subscriptions;
use App\Models\User;
use App\Notifications\OfflineVendorSubscriptionNotification;
use App\Notifications\OnetimePaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function subscription(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type == 1 || $vendor->user_type == 2) {
            return redirect('home');
        }

        $current_plans = (isset(auth()->user()->current_plans) && count(auth()->user()->current_plans) > 0) ? auth()->user()->current_plans[0] : null;
        $plan_id = isset($current_plans->plan_id) ? $current_plans->plan_id : 0;

        $subscription = Plans::find($plan_id);

        if (isset($current_plans->plan_id) && $current_plans->plan_id == 0) {
            $subscription = "trial";
        }

//        if ($subscription == null) {
//            return redirect('vendor/plan')->with('Error', trans('system.plans.subscription_expire'));
//        }

        $plans = Plans::where('status', 'active')->get();
        return view("restaurant.vendor_plan.subscription", compact('plans', 'vendor', 'subscription', 'current_plans'));
    }

    public function plan(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type == 1 || $vendor->user_type == 2) {
            return redirect('home');
        }

        $current_plans = (isset(auth()->user()->current_plans) && count(auth()->user()->current_plans) > 0) ? auth()->user()->current_plans[0]->plan_id : 0;

        $plans = Plans::where('status', 'active')->get();
        return view("restaurant.vendor_plan.index", compact('plans', 'current_plans'));
    }
    public function planDetails(Plans $plan)
    {
        $vendor = auth()->user();
        if (empty($vendor->email_verified_at)) {
            request()->session()->flash('Error', __('system.fields.email_unverified'));
            return redirect()->back();
        }

        if (empty($vendor->address) || empty($vendor->city) || empty($vendor->zip) || empty($vendor->country)) {
            request()->session()->flash('Error', __('system.dashboard.missing_address'));
            return redirect()->route('restaurant.profile.edit');
        }

        if ($vendor->user_type == 1 || $vendor->user_type == 2) {
            return redirect('home');
        }
        $current_plans = (isset(auth()->user()->current_plans) && count(auth()->user()->current_plans) > 0) ? auth()->user()->current_plans[0]->plan_id : 0;

        $current_plan_data = isset(auth()->user()->current_plans[0]) ? auth()->user()->current_plans[0] : null;
        if ($current_plan_data != null) {
            if ($current_plan_data->subscription_id != null && in_array($current_plan_data->type, array('monthly', 'weekly', 'yearly')) && $current_plan_data->status == 'approved' && $current_plan_data->expiry_date > date('Y-m-d H:i:s')) {
                return redirect()->back()->with('Error', __('system.plans.active_subscription_exist'));
            }
        }

        if ($current_plans == $plan->plan_id) {
            return redirect('vendor/plan');
        }


        $isAnyPaymentSystemEnabled = false;
        $stripe_data = Settings::where('title', 'stripe')->first();
        $paypal_data = Settings::where('title', 'paypal')->first();
        $offline_data = Settings::where('title', 'offline')->first();
        $paytm_data = Settings::where('title', 'paytm')->first();


        $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();
        $paypalPayment = ($paypal_data != null) ? json_decode($paypal_data->value) : array();
        $offlinePayment = ($offline_data != null) ? json_decode($offline_data->value) : array();
        $paytmPayment = ($paytm_data != null) ? json_decode($paytm_data->value) : array();
        $clientSecret = "";

        // show payment section
        if (!empty($stripePayment)) {
            if ($stripePayment->stripe_status == 'enable') {
                $isAnyPaymentSystemEnabled = true;
            }
        }

        if (!empty($offlinePayment)) {
            if ($offlinePayment->offline_status == 'enable') {
                $isAnyPaymentSystemEnabled = true;
            }
        }

        return view("restaurant.vendor_plan.details", compact('plan', 'offlinePayment', 'clientSecret', 'stripePayment', 'paypalPayment', 'paytmPayment', 'isAnyPaymentSystemEnabled'));
    }

    public function process(Request $request, Plans $plan)
    {
        $authUser = auth()->user();

        $extra_validate = [];
        if ($request->show_address) {
            $extra_validate = [
                "city" => 'required',
                "state" => 'required',
                "country" => 'required',
                "zip" => 'required',
                "address" => 'required',
            ];
        }

        $attributes = $request->validate([
            'payment_type' => 'in:stripe,paypal,offline',
        ] + $extra_validate);

        $checkExistingPlan = auth()->user()->load(['user_plans' => function ($userPlans) {
            $userPlans->where('payment_method', 'offline')->where('status', 'pending');
        }]);


        if (isset(auth()->user()->current_plans[0]) && auth()->user()->current_plans[0]->plan_id == $plan->plan_id) {
            return back()->with('Error', trans('system.plans.already_registered_plan'));
        }

        if (count($checkExistingPlan->user_plans) > 0 && request()->payment_type == 'offline') {
            return back()->with('Error', trans('system.plans.wait_until_approved_or_rejected'));
        }

        try {

            $expiredDate = null;
            if ($plan->type == 'weekly') {
                $expiredDate = now()->addWeek();
            } else if ($plan->type == 'monthly') {
                $expiredDate = now()->addMonth();
            } else if ($plan->type == 'yearly') {
                $expiredDate = now()->addYear();
            } else if ($plan->type == 'day') {
                $expiredDate = now()->addDay();
            }

            if ($request->show_address) {
                unset($attributes['payment_type']);
                $authUser->update($attributes);
            }

            $userPlan = new Subscriptions();
            $userPlan->user_id = auth()->id();
            $userPlan->plan_id = $plan->plan_id;
            $userPlan->start_date = now();
            $userPlan->expiry_date = $expiredDate;
            $userPlan->is_current = 'no';
            $userPlan->payment_method = $request->payment_type;
            $userPlan->amount = $plan->amount;
            $userPlan->type = $plan->type;
            $userPlan->table_limit = $plan->table_limit;
            $userPlan->restaurant_limit = $plan->restaurant_limit;
            $userPlan->item_limit = $plan->item_limit;
            $userPlan->staff_limit = $plan->staff_limit;
            $userPlan->item_unlimited = $plan->item_unlimited;
            $userPlan->table_unlimited = $plan->table_unlimited;
            $userPlan->staff_unlimited = $plan->staff_unlimited;
            $userPlan->restaurant_unlimited = $plan->restaurant_unlimited;
            $userPlan->status = 'pending';
            $userPlan->save();

            if ($plan->amount <= 0) {

                //Update subscription
                Subscriptions::where([
                    'user_id' => $userPlan->user_id, 'is_current' => 'yes'
                ])->update(['is_current' => 'no']);

                $userPlan->status = 'approved';
                $userPlan->is_current = 'yes';
                $userPlan->transaction_id = '0';
                $userPlan->save();

                return redirect('vendor/plan')->with('Success', trans('system.plans.play_change_success'));
            }

            $emailAttributes = [
                'vendor_name' => $authUser->name,
                'payment_amount' => $plan->amount,
                'payment_method' => '',
                'payment_date' => now(),
                'plan_name' => $plan->title,
                'payment_type' => $plan->type
            ];

            if ($request->payment_type == 'paypal') {

                if ($plan->type == "onetime") {
                    $payment = (new PaypalController())->paypalPayment($userPlan, $plan);
                    if ($payment) {
                        return redirect()->to($payment->getApprovalLink());
                    } else {
                        return redirect('vendor/plan')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
                    }
                } else {
                    return (new PaypalController())->process($request, $plan);
                }

                // example  of payment
                $emailAttributes['payment_method'] = 'Paypal';
                $emailAttributes['transaction_id'] = 'XYZ7748AF';
                $authUser->notify(new OnetimePaymentNotification($emailAttributes));
            } else if ($request->payment_type == 'stripe') {

                if ($userPlan->type == 'onetime') {
                    return (new StripeController())->onetimePayment($plan, $request, $userPlan);
                } else {
                    return (new StripeController())->subscriptionPayment($plan, $request, $userPlan);
                }
            } else if ($request->payment_type == 'offline') {

                $userPlan->transaction_id = $request->transaction_id;
                $userPlan->details = $request->reference;
                $userPlan->save();

                $adminUser = User::where('user_type', User::USER_TYPE_ADMIN)->first();
                if ($adminUser != null) {

                    $paymentDetails = [
                        'vendor_name' => $authUser->name,
                        'payment_amount' => $userPlan->amount,
                        'payment_method' => 'Offline',
                        'payment_reference' => $request->reference,
                        'admin_name' => $adminUser->first_name
                    ];

                    $adminUser->notify(new OfflineVendorSubscriptionNotification($paymentDetails));
                }
                return redirect('vendor/plan')->with('Success', trans('system.plans.request_received'));
            } else if ($request->payment_type == 'paytm') {

                $paytmData = $this->payTmPayment($plan, $request, $userPlan);
                return view('payment.paytm', $paytmData);
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect('vendor/plan')->with(['Error' => $ex->getMessage()]);
        }
    }

    public function subscriptionCancel(Subscriptions $subscription)
    {
        try {

            if ($subscription == null) {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }

            $plan_id = $subscription->plan_id;
            $user_id = $subscription->user_id;
            $subscription_id = $subscription->subscription_id;

            $userPlan = Subscriptions::where('id', $subscription->id)->where('is_current', 'yes')->first();

            if ($userPlan == null) {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }

            return (new StripeController())->subscriptionCancel($userPlan);
        } catch (\Exception $exception) {
            return redirect('vendor/subscription')->with(['Error' => $exception->getMessage()]);
        }
    }

    public function subscriptionManage(Subscriptions $subscription)
    {
        try {

            $authUser = auth()->user();

            if ($authUser->user_type != User::USER_TYPE_VENDOR) {
                return redirect('home');
            }

            $stripe_data = Settings::where('title', 'stripe')->first();
            $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

            $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            if ($subscription->subscription_id == null) {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }





            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            $stripe_data = $stripe->billingPortal->sessions->create([
                'customer' => $authUser->stripe_customer_id,
                'return_url' => url('home'),
            ]);
            if (isset($stripe_data->url)) {
                return redirect()->to($stripe_data->url);
            }

            return redirect('vendor/subscription');
        } catch (\Exception $exception) {
            return redirect('vendor/subscription')->with(['Error' => $exception->getMessage()]);
        }
    }
}
