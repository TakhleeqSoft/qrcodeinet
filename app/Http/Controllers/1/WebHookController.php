<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\Settings;
use App\Models\Transactions;
use App\Models\User;
use App\Models\WebhookData;
use App\Notifications\OnetimePaymentNotification;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Log;

class WebHookController extends Controller
{

    public function stripe()
    {
        $stripe_data = Settings::where('title', 'stripe')->first();
        $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

        $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

        \Stripe\Stripe::setApiKey($stripe_secret_key);


        $payload = @file_get_contents('php://input');
        $event = null;

        try {

            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );

            WebhookData::create([
                'type'=>$event->type,
                'response'=>$event,
            ]);

            switch ($event->type) {
                case 'invoice.paid':
                    //Log::info($event);

                    $paymentId= $event->data->object->id;
                    $subscription_id= $event->data->object->subscription;
                    $subscription_details= $event->data->object->subscription_details;
                    $subscription_data = $event->data->object->lines->data[0]->metadata;

                    $plan_id=$subscription_data->plan_id;
                    $user_id=$subscription_data->user_id;
                    $sub_id=$subscription_data->sub_id;

                    $user_plan_id=$subscription_details->metadata->sub_id;
                    $user_plan=Subscriptions::find($user_plan_id);

                    if($user_plan!=null){
                        //Make current subscription active
                        Subscriptions::where([
                            'user_id' => $user_plan->user_id,
                            'is_current' => 'yes'
                        ])->update(['is_current' => 'no']);

                        //Update Subscription
                        Subscriptions::where('id',$user_plan->id)->update([
                            'status'=>'approved',
                            'is_current'=>'yes',
                            'subscription_id'=>$subscription_id,
                            'json_response'=>json_encode($event),
                        ]);


                        //Add Transaction
                        $transaction_count=Transactions::where('user_id',$user_id)->where('plan_id',$plan_id)->where('subscription_id',$sub_id)->count();

                        if ($transaction_count>0){

                            $user_plan->transaction_id=$paymentId;

                            if ($user_plan->type == 'weekly') {
                                $user_plan->expiry_date = now()->addWeek();
                                $user_plan->save();

                            } else if ($user_plan->type == 'monthly') {
                                $user_plan->expiry_date = now()->addMonth();
                                $user_plan->save();

                            } else if ($user_plan->type == 'yearly') {
                                $user_plan->expiry_date = now()->addYear();
                                $user_plan->save();

                            }else if ($user_plan->type == 'day') {
                                $user_plan->expiry_date = now()->addDay();
                                $user_plan->save();

                            }
                        }

                        $current_subscription=Subscriptions::find($user_plan->id);

                        //Save Transaction
                        $this->saveTransaction($current_subscription,$paymentId,$current_subscription->user,$current_subscription->plan,$event->type);
                    }
                    break;
                case 'charge.succeeded':

                    $transaction_id=$event->data->object->balance_transaction;

                    $plan_id=$event->data->object->metadata->plan_id;
                    $user_id=$event->data->object->metadata->user_id;
                    $payment_type=$event->data->object->metadata->payment_type;
                    $amount=$event->data->object->metadata->amount;
                    $sub_id=$event->data->object->metadata->sub_id;

                    if (isset($sub_id) && $sub_id!=null){

                        $transaction_data=Transactions::where('transaction_id',$transaction_id)->first();

                        if($transaction_data==null){

                            $user_plan=Subscriptions::find($sub_id);

                            if($user_plan!=null){

                                //Make current subscription active
                                Subscriptions::where([
                                    'user_id' => $user_plan->user_id,
                                    'is_current' => 'yes'
                                ])->update(['is_current' => 'no']);


                                //Update Subscription
                                Subscriptions::where('id',$user_plan->id)->update([
                                    'status'=>'approved',
                                    'is_current'=>'yes',
                                    'transaction_id'=>$transaction_id,
                                    'subscription_id'=>null,
                                    'json_response'=>json_encode($event),
                                ]);

                                $current_subscription=Subscriptions::find($user_plan->id);

                                //Save Transaction
                                $this->saveTransaction($current_subscription,$transaction_id,$user_plan->user,$user_plan->plan,$event->type);

                            }
                        }
                    }

                    break;
                default:
            }

        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    protected function saveTransaction($user_plan,$transaction_id,$user_data,$plan_data,$event_type){

        //Save transaction details
        Transactions::updateOrCreate(['transaction_id'=>$transaction_id],[
            'user_id'=>$user_plan->user_id,
            'plan_id'=>$user_plan->plan_id,
            'subscription_id'=>$user_plan->id,
            'amount'=>$user_plan->amount,
            'details'=>$event_type,
            'payment_response'=>$user_plan->amount
        ]);

        //Send email
        $emailAttributes = [
            'vendor_name' => $user_data->name,
            'payment_amount' => $plan_data->amount,
            'payment_method' => 'Stripe',
            'payment_date' => now(),
            'plan_name' => $plan_data->title,
            'payment_type' => $plan_data->type,
            'transaction_id' => $transaction_id,
        ];
        $user_data->notify(new OnetimePaymentNotification($emailAttributes));
    }
}
