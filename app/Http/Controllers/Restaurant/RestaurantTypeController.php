<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use App\Models\RestaurantType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RestaurantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurantTypes = RestaurantType::get();
        return view('restaurant.restaurant_type.index', ["restaurantTypes" => $restaurantTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.restaurant_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        RestaurantType::create($request->only('type', 'lang_restaurant_type'));

        DB::commit();
        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.restaurant_type.type')]));
        return redirect(route('restaurant.restaurant-type.index'));
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
        $restaurantType = RestaurantType::where('id', $id)->first();

        if (empty($restaurantType)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Plan']));
            return redirect()->back();
        }

        return view('restaurant.restaurant_type.edit', ['restaurantType' => $restaurantType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restaurantType = RestaurantType::where('id', $id)->first();
        if (empty($restaurantType)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Restaurant Type']));
            return redirect()->back();
        }
        DB::beginTransaction();

        $restaurantType->update($request->only('type', 'lang_restaurant_type'));

        DB::commit();
        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.restaurant_type.type')]));
        return redirect(route('restaurant.restaurant-type.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurantType = RestaurantType::where('id', $id)->first();
        if (empty($restaurantType)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Restaurant Type']));
            return redirect()->back();
        }

        $restaurantType->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.restaurant_type.title')]));
        return redirect(route('restaurant.restaurant-type.index'));
    }
}
