<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Subscriptions;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
    public function process($request, $plan)
    {

        $authUser = auth()->user();

        $paypal_data = Settings::where('title', 'paypal')->first();
        $credentials = ($paypal_data != null) ? json_decode($paypal_data->value) : array();

        if ($credentials == null) {
            return redirect('vendor/plan')->with('Error', 'Paypal credentials not found.');
        }
        $currency = config('app.currency');

        $config = [
            'mode'    => isset($credentials->mode) ? $credentials->mode : 'sandbox',
            'sandbox' => [
                'client_id'         => $credentials->paypal_client_id,
                'client_secret'     => $credentials->paypal_secret_key,
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'payment_action' => 'Sale',
            'currency'       => $currency,
            'notify_url'     => url('paypal/notify'),
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];

        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        try {
            if ($plan->paypal_product_id == null) {
                $data =  json_decode('{
                          "name": "' . $plan->title . '",
                          "description": "' . config('app.name') . '",
                          "type": "SERVICE",
                          "category": "SOFTWARE"
                        }', true);

                $request_id = 'create-product-' . time();

                $product = $provider->createProduct($data, $request_id);
                if (isset($product['id']) && $product['id'] != null) {
                    $paypal_product_id = $product['id'];
                    $plan->paypal_product_id = $product['id'];
                    $plan->save();
                } else {
                    throw new \Exception('Unable to create product on paypal. Please try again.');
                }
            } else {
                $paypal_product_id = $plan->paypal_product_id;
            }

            $plan_type = "";
            $subscription_startdate = "";
            $subscription_expire_date = "";
            if ($plan->type == 'monthly') {
                $subscription_startdate = \Carbon\Carbon::now()->addMonth()->format('Y-m-d');
                $plan_type = "MONTH";
            } elseif ($plan->type == 'weekly') {
                $subscription_startdate = \Carbon\Carbon::now()->addWeek()->format('Y-m-d');
                $plan_type = "WEEK";
            } elseif ($plan->type == 'yearly') {
                $subscription_startdate = \Carbon\Carbon::now()->addYear()->format('Y-m-d');
                $plan_type = "YEAR";
            }

            if ($plan->paypal_plan_id == null) {

                $planData = json_decode('{
                  "product_id": "' . $paypal_product_id . '",
                  "name": "' . $plan->title . '",
                  "description": "' . config('app.name') . '",
                  "status": "ACTIVE",
                  "billing_cycles": [
                    {
                      "frequency": {
                        "interval_unit":"' . $plan_type . '",
                        "interval_count": 1
                      },
                      "tenure_type": "REGULAR",
                      "sequence": 1,
                      "total_cycles":"0",
                      "pricing_scheme": {
                        "fixed_price": {
                          "value":"' . $plan->amount . '",
                          "currency_code": "' . $currency . '"
                        }
                      }
                    }
                  ],
                  "payment_preferences": {
                    "auto_bill_outstanding": true,
                    "setup_fee": {
                      "value": "' . $plan->amount . '",
                      "currency_code": "' . $currency . '"
                    },
                    "setup_fee_failure_action": "CONTINUE",
                    "payment_failure_threshold": 3
                  }
                }', true);

                $paypal_plan = $provider->createPlan($planData, 'create-plan-' . time());

                if (isset($paypal_plan['id']) && $paypal_plan['id'] != null && $paypal_plan['id'] != "") {
                    $plan->paypal_plan_id = $paypal_plan['id'];
                    $plan->save();
                    $paypal_plan_id = $paypal_plan['id'];
                }
            } else {
                $paypal_plan_id = $plan->paypal_plan_id;
            }

            $response = $provider->addProductById($paypal_product_id)
                ->addBillingPlanById($paypal_plan_id)
                ->setReturnAndCancelUrl(route('restaurant.paypal.success'), route('restaurant.paypal.cancel'))
                ->setupSubscription($authUser->first_name . " " . $authUser->last_name, $authUser->email, $subscription_startdate);

            if (isset($response['error']) && !empty($response['error'])) {
                throw new \Exception('Unable to create product on paypal. Please try again.');
            }

            if (isset($response['status']) && $response['status'] == "APPROVAL_PENDING") {
                if (isset($response['links'][0]['href']) && $response['links'][0]['href'] != null) {
                    return redirect()->to($response['links'][0]['href']);
                }
            }
        } catch (\Exception $exception) {
            return redirect('vendor/plan')->with('Error', $exception->getMessage());
        }
    }

    public function notify(Request $request)
    {
    }

    public function processSuccess(Request $request)
    {

        $subscription_id = $request->subscription_id;
        $ba_token = $request->ba_token;
        $token = $request->token;

        $paypal_data = Settings::where('title', 'paypal')->first();
        $credentials = ($paypal_data != null) ? json_decode($paypal_data->value) : array();

        if (!$credentials->paypal_client_id || !$credentials->paypal_secret_key) {
            return redirect('vendor/plan')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }

        $currency = config('app.currency');
        $config = [
            'mode'    => isset($credentials->mode) ? $credentials->mode : 'sandbox',
            'sandbox' => [
                'client_id'         => $credentials->paypal_client_id,
                'client_secret'     => $credentials->paypal_secret_key,
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'payment_action' => 'Sale',
            'currency'       => $currency,
            'notify_url'     => url('paypal/notify'),
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];

        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $subscription = $provider->showSubscriptionDetails($subscription_id);
        dd($subscription);

        $apiContext = $this->getPaypalApiContext($credentials->paypal_client_id, $credentials->paypal_secret_key);

        $paymentId = $request->paymentId;
        $user_plan_id = $request->plan;
        $sub = $request->sub;
        $user = $request->user;

        if (!$paymentId || !$user_plan_id || !$user) {
            return redirect('vendor/plan')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }

        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (\Exception $ex) {
            exit(1);
        }

        if (!$payment) return redirect('vendor/plan')->withErrors(['msg' => trans('system.plans.invalid_payment')]);

        $url = $payment->getRedirectUrls();
        $parsed_url = parse_url($url->getReturnUrl());
        $query_string = $parsed_url["query"];
        parse_str($query_string, $array_of_query_string);

        if ($array_of_query_string["plan"] != $user_plan_id || $array_of_query_string['sub'] != $sub || $array_of_query_string["user"] != $user || $array_of_query_string['paymentId'] != $paymentId) {
            return redirect('vendor/plan')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }

        $userPlan = Subscriptions::where('id', $sub)->where('user_id', $user)->where('plan_id', $user_plan_id)->first();

        if (!$userPlan) {
            return redirect('vendor/plan')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }
        Subscriptions::where(['user_id' => $user, 'is_current' => 'yes'])->update(['is_current' => 'no']);

        $userPlan->status = 'approved';
        $userPlan->is_current = 'yes';
        $userPlan->transaction_id = $paymentId;
        $userPlan->save();

        Transactions::updateOrCreate(['transaction_id' => $paymentId], [
            'user_id' => $user,
            'plan_id' => $user_plan_id,
            'subscription_id' => $userPlan->id,
            'amount' => $userPlan->amount,
            'payment_response' => json_encode($array_of_query_string),
        ]);

        return redirect('vendor/plan')->with('Success', trans('system.plans.play_change_success'));
    }

    public function processCancelled()
    {
        return redirect('vendor/plan')->withErrors(['msg' => "Payment has been cancelled"]);
    }

    function paypalPayment($userPlan, $plan)
    {

        $paypal_data = Settings::where('title', 'paypal')->first();
        $credentials = ($paypal_data != null) ? json_decode($paypal_data->value) : array();

        $apiContext = $this->getPaypalApiContext($credentials->paypal_client_id, $credentials->paypal_secret_key);

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $currency = config('app.currency');
        $amount = new \PayPal\Api\Amount();

        $amount->setTotal($plan->amount);
        $amount->setCurrency($currency); //TODO:: get the currency

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('restaurant.paypal.success', [
            'sub' => $userPlan->id,
            'plan' => $userPlan->plan_id,
            'user' => $userPlan->user_id
        ]))->setCancelUrl(route('restaurant.paypal.cancel'));


        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            return $payment;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {

            Log::error($ex->getData());
        }
        return null;
    }

    function getPaypalApiContext($client_id, $secret_key)
    {
        return new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $client_id,     // ClientID
                $secret_key      // ClientSecret
            )
        );
    }
}
