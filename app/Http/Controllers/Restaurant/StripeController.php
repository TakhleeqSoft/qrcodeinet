<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\Settings;
use App\Models\Subscriptions;
use App\Models\Transactions;
use App\Notifications\OnetimePaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function onetimePayment($plan, $request, $userPlan)
    {
        $authUser = auth()->user();

        try {

            $currency = config('app.currency');
            $stripe_data = Settings::where('title', 'stripe')->first();
            $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

            $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            //Subscription
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            \Stripe\Stripe::setApiKey($stripe_secret_key);

            $metaDatas = [
                'sub_id' => $userPlan->id,
                'user_id' => $userPlan->user_id,
                'plan_id' => $plan->plan_id,
                'amount' => $plan->amount,
                'payment_type' => 'onetime',
            ];

            //Product
            $stripe_product_id = $plan->stripe_product_id;

            if ($plan->stripe_product_id == null) {

                $product = $stripe->products->create([
                    'name' => $plan->title,
                ]);

                $stripe_product_id = $product->id;
                $plan->stripe_product_id = $product->id;
                $plan->save();
            }

            //Price
            $price_array = [
                'unit_amount' => $plan->amount * 100,
                'currency' => $currency,
                'product' => $stripe_product_id
            ];

            $price = $stripe->prices->create($price_array);

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1
                ]],
                'mode' => 'payment',
                'success_url' => url('stripe/onetime-success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('stripe/onetime-cancelled?subscription=' . $userPlan->id),
                'client_reference_id' => $userPlan->id,
                'metadata' => $metaDatas,
                'payment_intent_data' => [
                    'metadata' => $metaDatas
                ]
            ]);
            return redirect()->to($checkout_session->url);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }


    public function onetimeSuccess(Request $request)
    {
        $session_id = ($request->session_id);
        try {
            $authUser = auth()->user();
            $stripe_data = Settings::where('title', 'stripe')->first();
            $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

            $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            \Stripe\Stripe::setApiKey($stripe_secret_key);

            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);

            $client_reference_id = ($checkout_session->client_reference_id);
            $subscription_id = ($checkout_session->subscription);
            $invoice = ($checkout_session->invoice);
            $payment_intent = ($checkout_session->payment_intent);

            $payment_intent_data = $stripe->paymentIntents->retrieve(
                $payment_intent,
                []
            );

            $transaction_id = ($payment_intent_data->charges->data[0]->balance_transaction);

            $plan_id = ($payment_intent_data->metadata->plan_id);
            $user_id = ($payment_intent_data->metadata->user_id);
            $amount = ($payment_intent_data->metadata->amount);

            $userPlan = Subscriptions::find($client_reference_id);
            $plan = Plans::find($plan_id);

            //save stripe customer id in user table
            $authUser->stripe_customer_id = $checkout_session->customer;
            $authUser->save();

            //Make current subscription active
            Subscriptions::where([
                'user_id' => $user_id,
                'is_current' => 'yes'
            ])->update(['is_current' => 'no']);


            $current_subscription = Subscriptions::find($client_reference_id);
            $current_subscription->status = 'approved';
            $current_subscription->is_current = 'yes';
            $current_subscription->transaction_id = $transaction_id;
            $current_subscription->subscription_id = null;
            $current_subscription->remark = json_encode($checkout_session);
            $current_subscription->save();

            //Save transaction
            Transactions::updateOrCreate(['transaction_id' => $transaction_id], [
                'user_id' => $user_id,
                'plan_id' => $plan_id,
                'subscription_id' => $current_subscription->id,
                'amount' => $current_subscription->amount,
                'payment_response' => json_encode($checkout_session)
            ]);

            $emailAttributes = [
                'vendor_name' => $authUser->name,
                'payment_amount' => $amount,
                'payment_method' => 'Stripe',
                'payment_date' => now(),
                'plan_name' => $plan->title,
                'payment_type' => $plan->type,
                'transaction_id' => $subscription_id,
            ];

            $authUser->notify(new OnetimePaymentNotification($emailAttributes));

            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $exception) {
            return redirect('home')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }
    }

    public function onetimeCancelled(Request $request)
    {

        $subscription = Subscriptions::find($request->subscription);
        $subscription->delete();

        return redirect('home')->with('Error', trans('system.messages.operation_canceled'));
    }

    public function subscriptionPayment($plan, $request, $userPlan)
    {

        $currency = config('app.currency');
        try {

            $authUser = auth()->user();
            $stripe_data = Settings::where('title', 'stripe')->first();
            $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

            $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            if ($plan->type == 'weekly') {
                $recurring_type = 'week';
            } else if ($plan->type == 'monthly') {
                $recurring_type = 'month';
            } else if ($plan->type == 'yearly') {
                $recurring_type = 'year';
            } else if ($plan->type == 'day') {
                $recurring_type = 'day';
            } else {
                $recurring_type = '';
            }

            //Subscription
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            \Stripe\Stripe::setApiKey($stripe_secret_key);

            //Customer

            if (!$recurring_type || $recurring_type == "" || $recurring_type == null) {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            //Product
            $stripe_product_id = $plan->stripe_product_id;

            if ($plan->stripe_product_id == null) {

                $product = $stripe->products->create([
                    'name' => $plan->title,
                ]);

                $stripe_product_id = $product->id;
                $plan->stripe_product_id = $product->id;
                $plan->save();
            }


            //Price
            $price_array = [
                'unit_amount' => $plan->amount * 100,
                'currency' => $currency,
                'product' => $stripe_product_id,
            ];

            $metaDatas = [
                'sub_id' => $userPlan->id,
                'user_id' => $userPlan->user_id,
                'plan_id' => $plan->plan_id,
                'amount' => $plan->amount,
            ];

            $price_array['recurring'] = ['interval' => $recurring_type];
            $price = $stripe->prices->create($price_array);

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1
                ]],
                'mode' => 'subscription',
                'success_url' => url('stripe/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('stripe/onetime-cancelled?subscription=' . $userPlan->id),
                'client_reference_id' => $userPlan->id,
                'metadata' => $metaDatas,
                'subscription_data' => [
                    'metadata' => $metaDatas
                ]
            ]);

            return redirect()->to($checkout_session->url);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            throw new \Exception(trans('system.plans.invalid_payment'));
        }
    }


    public function processSuccess(Request $request)
    {
        $session_id = ($request->session_id);
        try {
            $authUser = auth()->user();
            $stripe_data = Settings::where('title', 'stripe')->first();
            $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

            $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            \Stripe\Stripe::setApiKey($stripe_secret_key);
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);


            $client_reference_id = ($checkout_session->client_reference_id);
            $subscription_id = ($checkout_session->subscription);
            $invoice = ($checkout_session->invoice);

            $plan_id = ($checkout_session->metadata->plan_id);
            $user_id = ($checkout_session->metadata->user_id);
            $amount = ($checkout_session->metadata->amount);

            // $userPlan = Subscriptions::find($client_reference_id);
            // dd($userPlan);

            $plan = Plans::find($plan_id);


            //save stripe customer id in user table
            $authUser->stripe_customer_id = $checkout_session->customer;
            $authUser->save();

            //Make current subscription active
            Subscriptions::where([
                'user_id' => $user_id,
                'is_current' => 'yes'
            ])->update(['is_current' => 'no']);


            $current_subscription = Subscriptions::find($client_reference_id);
            $current_subscription->status = 'approved';
            $current_subscription->is_current = 'yes';
            $current_subscription->subscription_id = $subscription_id;
            $current_subscription->remark = json_encode($checkout_session);
            $current_subscription->save();

            //Save transaction
            Transactions::updateOrCreate(['transaction_id' => $invoice], [
                'user_id' => $current_subscription->user_id,
                'plan_id' => $current_subscription->plan_id,
                'subscription_id' => $current_subscription->id,
                'amount' => $current_subscription->amount,
                'payment_response' => json_encode($checkout_session)
            ]);

            $emailAttributes = [
                'vendor_name' => $authUser->name,
                'payment_amount' => $amount,
                'payment_method' => 'Stripe',
                'payment_date' => now(),
                'plan_name' => $plan->title,
                'payment_type' => $plan->type,
                'transaction_id' => $subscription_id,
            ];
            $authUser->notify(new OnetimePaymentNotification($emailAttributes));
            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect('home')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }
    }

    public function processCancelled(Request $request)
    {
        return redirect('vendor/subscription')->with('Error', trans('system.messages.operation_canceled'));
    }

    public function subscriptionCancel($userPlan)
    {
        $stripe_data = Settings::where('title', 'stripe')->first();
        $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

        $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

        if (!$stripe_secret_key || $stripe_secret_key == "") {
            throw new \Exception(trans('system.plans.invalid_payment'));
        }

        $stripe = new \Stripe\StripeClient($stripe_secret_key);
        $result = $stripe->subscriptions->cancel(
            $userPlan->subscription_id,
            []
        );
        if ($result->status == 'canceled') {
            $userPlan->subscription_id = null;
            $userPlan->status = 'canceled';
            $userPlan->save();
            return redirect()->back()->with('Success', trans('system.plans.cancel_subscription_success'));
        } else {
            throw new \Exception(trans('system.plans.invalid_payment'));
        }
    }
}
