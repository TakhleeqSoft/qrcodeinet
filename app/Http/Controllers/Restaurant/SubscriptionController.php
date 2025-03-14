<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\Transactions;
use App\Notifications\ActionVendorSubscriptionNotification;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscriptions(Request $request)
    {

        $subscriptions = Subscriptions::orderBy('created_at', 'desc')->where(function ($query) use ($request) {

            if (isset($request->action) && $request->action == 'approved') {
                $query->where('status', "approved");
            } elseif (isset($request->action) && $request->action == 'rejected') {
                $query->where('status', "rejected");
            } else {
                $query->where('status', "pending");
            }
        })->get();
        return view("restaurant.subscriptions.index", compact('subscriptions'));
    }

    public function approve(Request $request, Subscriptions $subscription)
    {
        $paymentId = uniqid();

        Subscriptions::where([
            'user_id' => $subscription->user_id,
            'is_current' => 'yes'
        ])->update(['is_current' => 'no']);

        //Update approved plan to current plan
        $subscription->status = 'approved';
        $subscription->is_current = 'yes';
        $subscription->save();

        Transactions::updateOrCreate(['transaction_id' => $paymentId], [
            'user_id' => $subscription->user_id,
            'plan_id' => $subscription->plan_id,
            'subscription_id' => $subscription->id,
            'amount' => $subscription->amount
        ]);

        $subUser = $subscription->load('user')->user;
        $subUser->notify(new ActionVendorSubscriptionNotification($subUser->name));

        return redirect()->back()->with('Success', trans('system.plans.userplan_approve_success'));
    }

    public function reject(Request $request, Subscriptions $subscription)
    {
        $subscription->status = 'rejected';
        $subscription->is_current = 'no';
        $subscription->save();

        $subUser = $subscription->load('user')->user;
        $subUser->notify(new ActionVendorSubscriptionNotification($subUser->name, 'declined'));
        return redirect()->back()->with('Success', trans('system.plans.userplan_reject_success'));
    }

    public function pending(Request $request, Subscriptions $subscription)
    {
        $subscription->status = 'pending';
        $subscription->is_current = 'no';
        $subscription->save();

        return redirect()->back()->with('Success', trans('system.plans.userplan_status_change_msg'));
    }

    public function delete(Request $request, Subscriptions $subscription)
    {
        $subscription->delete();
        return redirect()->back()->with('Success',  __('system.messages.deleted', ['model' => __('system.plans.title')]));
    }
}
