<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Plans;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\Restaurant\PlanRequest;
use App\Repositories\Restaurant\PlanRepository;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'plan_id');
        $params['plan_id'] = $params['plan_id'] ?? $user->plan_id;
        $plans = (new PlanRepository())->allPlan($params);
        $trial_days = config('app.trial_days');
        $trial_restaurant = config('app.trial_restaurant');
        $trial_food = config('app.trial_food');
        $trial_staff = config('app.trial_staff');
        return view('restaurant.plans.index', ['plans' => $plans, 'trial_days' => $trial_days, 'trial_restaurant' => $trial_restaurant, 'trial_food' => $trial_food,'trial_staff' => $trial_staff]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        try {
            DB::beginTransaction();

            $request['type'] = $request->recurring_type;
            if ($request->is_item_unlimited == 'yes') {
                unset($request['is_item_unlimited']);
                $request['item_unlimited'] = 'yes';
                $request['item_limit'] = 0;
            } else {
                $request['item_unlimited'] = 'no';
            }

            if ($request->is_table_unlimited == 'yes') {
                unset($request['is_table_unlimited']);
                $request['table_unlimited'] = 'yes';
                $request['table_limit'] = 0;
            } else {
                $request['table_unlimited'] = 'no';
            }

            if ($request->is_staff_unlimited == 'yes') {
                unset($request['is_staff_unlimited']);
                $request['staff_unlimited'] = 'yes';
                $request['staff_limit'] = 0;
            } else {
                $request['staff_unlimited'] = 'no';
            }

            if ($request->is_restaurant_unlimited == 'yes') {
                unset($request['is_restaurant_unlimited']);
                $request['restaurant_unlimited'] = 'yes';
                $request['restaurant_limit'] = 0;
            } else {
                $request['restaurant_unlimited'] = 'no';
            }

            Plans::create($request->all());
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.plans.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('restaurant.plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plans::where('plan_id', $id)->first();
        if (empty($plan)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Plan']));
            return redirect()->back();
        }

        $subscription_count=Subscriptions::where('plan_id',$plan->plan_id)->whereIn('status',array('pending','approved'))->count();

        if ($subscription_count>0){
            request()->session()->flash('Error', __('system.plans.plan_already_subscribed'));
            return redirect()->back();
        }

        return view('restaurant.plans.edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
    {
        $plan = Plans::where('plan_id', $id)->first();
        if (empty($plan)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Plan']));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $request['type'] = $request->recurring_type;
            if ($request->is_item_unlimited == 'yes') {
                unset($request['is_item_unlimited']);
                $request['item_unlimited'] = 'yes';
                $request['item_limit'] = 0;
            } else {
                $request['item_unlimited'] = 'no';
            }

            if ($request->is_table_unlimited == 'yes') {
                unset($request['is_table_unlimited']);
                $request['table_unlimited'] = 'yes';
                $request['table_limit'] = 0;
            } else {
                $request['table_unlimited'] = 'no';
            }

            if ($request->is_staff_unlimited == 'yes') {
                unset($request['is_staff_unlimited']);
                $request['staff_unlimited'] = 'yes';
                $request['staff_limit'] = 0;
            } else {
                $request['staff_unlimited'] = 'no';
            }

            if ($request->is_restaurant_unlimited == 'yes') {
                unset($request['is_restaurant_unlimited']);
                $request['restaurant_unlimited'] = 'yes';
                $request['restaurant_limit'] = 0;
            } else {
                $request['restaurant_unlimited'] = 'no';
            }

            $plan->update($request->all());

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.plans.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect(route('restaurant.plans.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plans $plan)
    {
        $subscriptions = Subscriptions::where('plan_id', $plan->plan_id)->count();
        if ($subscriptions > 0) {
            request()->session()->flash('Error', __('system.plans.not_allowed_to_delete', ['name' => $plan->title]));
            return redirect()->back();
        }

        $plan->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.plans.title')]));
        return redirect(route('restaurant.plans.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function trailDetails(Request $request)
    {
        $request->validate([
            'trial_days' => ['required','integer'],
            'restaurant_limit' => ['required','integer'],
            'item_limit' => ['required','integer'],
            'staff_limit' => ['required','integer'],
        ]);

        $data = [
            'TRIAL_DAYS' => $request->trial_days,
            'TRIAL_RESTAURANT' => $request->restaurant_limit,
            'TRIAL_FOOD' => $request->item_limit,
            'TRIAL_STAFF' => $request->staff_limit,
        ];
        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');
        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }
}
