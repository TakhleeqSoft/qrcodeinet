<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Waiter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallWaiterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $user->loadMissing('restaurants');
        $waiters = Waiter::where(function ($thisQuery) use ($user) {
            if ($user->user_type != 2) {
                $thisQuery->where('waiters.user_id', $user->id);
            } else {
                $thisQuery->whereIn('waiters.restaurant_id', $user->restaurants->pluck('id')->toArray());
            }
        })->with('restaurant', 'table')->hasFilter()->select('waiters.*')->get();
        return view('restaurant.waiters.index', ['waiters' => $waiters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Waiter::where('id', $id)->delete();
        return redirect()->back()->with('Success', __('system.call_waiters.delete'));
    }
}
