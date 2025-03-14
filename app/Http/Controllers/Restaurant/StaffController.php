<?php

namespace App\Http\Controllers\Restaurant;

use Exception;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Restaurant\UserRequest;
use App\Http\Requests\Restaurant\StaffRequest;
use App\Repositories\Restaurant\StaffRepository;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show staff')->only('index','show');
        $this->middleware('permission:add staff')->only('create','store');
        $this->middleware('permission:edit staff')->only('edit','update');
        $this->middleware('permission:delete staff')->only('destroy');
    }
    public function index()
    {

        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = 10;
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }

        $owner_id = $user->id;
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $user->created_by;
        }

        $params['par_page'] = $par_page;
        $params['created_by'] = $owner_id;
        $params['user_id'] = $user->id;

        $users = (new StaffRepository())->getRestaurantUsers($params);

        return view('restaurant.staff.index', ['users' => $users]);
    }

    public function create()
    {

        $user = auth()->user();
        $owner_id = $user->id;
        $assigned_restaurant=array();

        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $user->created_by;
            $assigned_restaurant=RestaurantUser::where('user_id',$user->id)->pluck('restaurant_id')->toArray();
        }

        if (!$this->checkPlan($user)) {
            return redirect()->route('restaurant.staff.index')->with(['Error' => __('system.plans.staff_extends')]);
        }

        $restaurants = Restaurant::select('id', 'name')
            ->where('user_id', $owner_id)
            ->when(isset($assigned_restaurant), function ($query) use ($assigned_restaurant) {
                if (count($assigned_restaurant)>0){
                    $query->whereIn('id',$assigned_restaurant);
                }
            })
            ->orderBY('name', 'asc')->get();
        $staffRestaurant = array();
        return view('restaurant.staff.create', compact('restaurants', 'staffRestaurant'));
    }

    public function store(StaffRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = auth()->user();
            if (!$this->checkPlan($user)) {
                return redirect()->route('restaurant.staff.index')->with(['Error' => __('system.plans.staff_extends')]);
            }
            $data = $request->all();

            $owner_id = $user->id;
            if ($user->user_type == User::USER_TYPE_STAFF) {
                $owner_id = $user->created_by;
            }

            $newUser = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'profile_image' => $data['profile_image'] ?? null,
                'password' => Hash::make($data['password']),
                'status' => User::STATUS_ACTIVE,
                'created_by' => $owner_id,
                'restaurant_id' => $user->restaurant_id,
                'user_type' => User::USER_TYPE_STAFF,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);

            foreach ($request->restaurants as $key => $restaurant_id) {
                RestaurantUser::create([
                    'restaurant_id' => $restaurant_id,
                    'user_id' => $newUser->id,
                    'role' => RestaurantUser::ROLE_STAFF,
                ]);

                //Set Default Restro
                if ($key == 0) {
                    $newUser->restaurant_id = $restaurant_id;
                    $newUser->save();
                }
            }

            //Save permission
            $newUser->assignRole('staff');

            if (isset($data['permission']) && count($data['permission']) > 0) {
                $newUser->givePermissionTo($data['permission']);
            }

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.staffs.title')]));
        } catch (Exception $e) {

            DB::rollBack();
            $request->session()->flash('Error', __('system.fields.something_went_wrong'));
        }
        return redirect(route('restaurant.staff.index'));
    }

    public function show(User $staff)
    {
        if (($redirect = $this->checkRestaurantIsValidUser($staff)) != null) {
            return redirect($redirect);
        }
        return view('restaurant.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {

        $user = auth()->user();

        if (($redirect = $this->checkRestaurantIsValidUser($staff)) != null) {
            return redirect($redirect);
        }

        $owner_id = $user->id;
        $assigned_restaurant=array();

        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $user->created_by;
            $assigned_restaurant=RestaurantUser::where('user_id',$user->id)->pluck('restaurant_id')->toArray();
        }

        $staffRestaurant = RestaurantUser::where('user_id', $staff->id)->pluck('restaurant_id')->toArray();

        $restaurants = Restaurant::select('id', 'name')
            ->where('user_id', $owner_id)
            ->when(isset($assigned_restaurant), function ($query) use ($assigned_restaurant) {
                if (count($assigned_restaurant)>0){
                    $query->whereIn('id',$assigned_restaurant);
                }
            })
            ->orderBY('name', 'asc')->get();

        return view('restaurant.staff.edit', ['user' => $staff, 'staffRestaurant' => $staffRestaurant, 'restaurants' => $restaurants]);
    }

    public function update(StaffRequest $request, User $staff)
    {

        if (($redirect = $this->checkRestaurantIsValidUser($staff)) != null) {
            return redirect($redirect);
        }

        $data = $request->only('first_name', 'email', 'last_name', 'phone_number', 'permission', 'profile_image');
        $staff->fill($data)->save();

        RestaurantUser::where('user_id', $staff->id)->delete();

        foreach ($request->restaurants as $key => $restaurant_id) {
            RestaurantUser::create([
                'restaurant_id' => $restaurant_id,
                'user_id' => $staff->id,
                'role' => RestaurantUser::ROLE_STAFF,
            ]);

            //Set Default Restro
            if ($key == 0) {
                $staff->restaurant_id = $restaurant_id;
                $staff->save();
            }
        }

        //Update Permission
        if (isset($data['permission']) && count($data['permission']) > 0) {
            $staff->syncPermissions($data['permission']);
        }

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.staffs.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('restaurant.staff.index'));
    }

    public function checkRestaurantIsValidUser($staff)
    {
        $login_user = auth()->user();

        if ($login_user->user_type == User::USER_TYPE_ADMIN) {
            return route('restaurant.staff.index');
        }

        $owner_id = $login_user->id;
        if ($staff->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $staff->created_by;
        }

        if ($staff->created_by != $owner_id) {
            $back = request()->get('back', route('restaurant.staff.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.staffs.title')]));
            return $back;
        }
    }

    public function destroy(User $staff)
    {
        $request = request();

        if (($redirect = $this->checkRestaurantIsValidUser($staff)) != null) {
            return redirect($redirect);
        }

        RestaurantUser::where('user_id', $staff->id)->delete();

        $staff->delete();

        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.staffs.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('restaurant.staff.index'));
    }

    protected function checkPlan($user)
    {


        $userPlan = isset($user->current_plans[0]) ? $user->current_plans[0] : '';
        if ($user->user_type==User::USER_TYPE_STAFF) {
            $owner=User::find($user->created_by);
            $userPlan = isset($owner->current_plans[0]) ? $owner->current_plans[0] : '';
        }


        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
        $staffCount = User::where('created_by', $vendor_id)->where('user_type', User::USER_TYPE_STAFF)->count();


        if ($user->user_type != User::USER_TYPE_ADMIN && $userPlan && $user->free_forever != true) {
            if ((!$userPlan || $staffCount >= $userPlan->staff_limit) && $userPlan->staff_unlimited != 'yes') {
                return false;
            }
        } else if ($user->user_type != User::USER_TYPE_ADMIN && !$userPlan) {
            return false;
        }
        return true;
    }

    public function updatePassword(Request $request, User $staff)
    {
        try {

            $this->validate($request, [
                'new_password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'same:new_password']
            ]);

            $staff->password = Hash::make($request->new_password);
            $staff->save();

            $request->session()->flash('Success', __('system.messages.change_success_message', ['model' => __('system.fields.password')]));
            return back()->with('success', 'Password change successfully');
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }
}
