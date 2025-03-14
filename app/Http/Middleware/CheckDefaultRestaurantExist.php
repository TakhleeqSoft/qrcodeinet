<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckDefaultRestaurantExist
{
    public function handle(Request $request, Closure $next)
    {

        $user = auth()->user();
        if ($user->user_type != User::USER_TYPE_ADMIN) {

            $vendor_id = $user->id;
            if ($user->user_type == User::USER_TYPE_STAFF) {
                $user = User::find($user->created_by);
            }

            //If not current plan then send back plan purchase
            if (!isset($user->current_plans[0]) || $user->current_plans[0] == null) {

                if (auth()->user()->user_type == User::USER_TYPE_STAFF) {
                    return redirect('staff/plan')->with('Error', __('system.plans.subscription_expire'));
                }

                return redirect('vendor/plan')->with('Error', __('system.plans.subscription_expire'));
            }
        }
        return $next($request);
    }
}
