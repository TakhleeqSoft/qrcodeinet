<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Feedback;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\FoodCategory;
use App\Models\Settings;
use App\Models\Subscriptions;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Permission;
use App\Repositories\Restaurant\FoodRepository;
use App\Repositories\Restaurant\UserRepository;
use App\Repositories\Restaurant\RestaurantRepository;
use App\Repositories\Restaurant\FoodCategoryRepository;

class HomeController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        $params = [];

        $count['payment_setting_count'] = Settings::whereIn('title', ['stripe', 'offline'])->count();

        if ($user->user_type == User::USER_TYPE_STAFF) {
            $params['user_id'] = $user->created_by;
        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $params['user_id'] = $user->id;
        }

        $count['restaurants_count'] = (new RestaurantRepository())->getCountRestaurants($params);
        $count['vendors_count'] = (new UserRepository())->getRestaurantUsersQuery([])->count();


        if (!$user->hasRole('Super-Admin')) {

            $restaurant_id = isset($restaurant->id) ? $restaurant->id : 0;

            $count['users_count'] = (new UserRepository())->getMyStaff(['id' => $user->id]);
            $count['categories_count'] = (new FoodCategoryRepository)->getCountRestaurantFoodCategories(['restaurant_id' => $restaurant_id]);

            $count['foods_count'] = (new FoodRepository())->getUserRestaurantFoodCount(['restaurant_id' => $restaurant_id]);
            $count['restaurants'] = (new RestaurantRepository())->getUserRestaurantsDetails(['user_id' => $user->id, 'latest' => 1, 'recodes' => 6]);

            $count['users'] = (new UserRepository())->getVendorStaff(['user_id' => $user->id, 'recodes' => 6]);
            $count['categories'] = (new FoodCategoryRepository)->getRestaurantCategories(['restaurant_id' => $restaurant_id, 'recodes' => 6]);
            $count['foods'] = (new FoodRepository)->getUserRestaurantFoodsCustome(['restaurant_id' => $restaurant_id, 'recodes' => 6]);
        } else {
            $count['users_count']=User::where('user_type',User::USER_TYPE_STAFF)->count();
            $count['subscriptions'] = Subscriptions::orderBy('created_at', 'desc')->where('status', "pending")
                ->with(['user' => function ($thisUser) {
                    $thisUser->select('id', 'first_name', 'last_name', 'profile_image', 'email');
                }, 'plan' => function ($thisPlan) {
                    $thisPlan->select('plan_id', 'title');
                }])
                ->select('id', 'user_id', 'plan_id', 'amount')
                ->get();
            $count['pending_subscriptions'] = count($count['subscriptions']);
        }

        return view('home', $count);
    }

    public static function getCurrentUsersAllRestaurants()
    {
        $user = auth()->user();
        $params = [];


        if ($user->user_type == User::USER_TYPE_STAFF) {
            $params['user_id'] = $user->id;
        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $params['user_id'] = $user->id;
        } elseif ($user->user_type == User::USER_TYPE_ADMIN) {
            $params['admin_user_id'] = $user->id;
        }
        $params['debug'] = 1;
        return (new RestaurantRepository())->getUserRestaurantsDetails($params);
    }


    public function globalSearch()
    {
        $request = request();
        $search = [];
        if (strlen($request->search) > 2) {
            $search = globalSearch($request->search, $request->user());
        }
        return view('layouts.search')->with('search', $search);
    }

    public function getRightBarContent(Request $request)
    {
        $action = $request->action;
        $id = (int)$request->id;
        if ($action == 'feedbacks') {
            $feedback = Feedback::find($id);
            return view('restaurant.feedbacks.sidebar', compact('feedback'))->render();
        }

        if ($action == 'contact-us') {
            $contact_data = ContactUs::find($id);
            return view('restaurant.contact_us.sidebar', compact('contact_data'))->render();
        }

        if ($action == 'testimonials') {
            $testimonial = Testimonial::find($id);
            return view('restaurant.testimonial.sidebar', compact('testimonial'))->render();
        }

        if ($action == 'subscription-history') {
            $subscription = Subscriptions::where('id',$id)->with('plan')->first();
            return view('restaurant.vendors.sidebar', compact('subscription'))->render();
        }
    }
}
