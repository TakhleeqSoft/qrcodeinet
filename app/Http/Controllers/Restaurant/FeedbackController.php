<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Feedback;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Restaurant\FeedbackRepository;

class FeedbackController extends Controller
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
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'id');

        $par_page = 10;
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;


        $params['restaurant_id'] = $user->restaurant_id??0;

        $vendor_id=($user->user_type==User::USER_TYPE_STAFF)?$user->created_by:$user->id;

        $params['id'] = $vendor_id;
        $feedbacks = (new FeedbackRepository())->allFeedback($params);
        return view('restaurant.feedbacks.index', ['feedbacks' => $feedbacks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributes = request()->validate([
            "restaurant_id" => 'required',
            "name" => 'required|max:255',
            "email" => 'required|email|max:255',
            "message" => 'required|min:5|max:512',
        ]);

        $restaurant = Restaurant::where('id', $request->restaurant_id)->first();

        if (empty($restaurant)) {
            return redirect('/')->with('Success', trans('system.plans.request_received'));
        }

        $attributes['user_id'] = $restaurant->user_id;
        Feedback::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'message' => $attributes['message'],
            'user_id' => $attributes['user_id'],
            'restaurant_id' => intval($attributes['restaurant_id']),
        ]);



        $request->session()->flash('Success', __('system.feedback.success'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeedBack  $feedBack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        if (empty($feedback)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Feedback']));
            return redirect()->back();
        }
        $feedback->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.feedbacks.menu')]));
        return redirect(route('restaurant.feedbacks.index'));
    }
}
