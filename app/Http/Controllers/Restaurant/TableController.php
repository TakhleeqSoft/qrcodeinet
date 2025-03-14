<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\User;
use App\Models\Table;
use App\Models\Restaurant;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Restaurant\TableRepository;

class TableController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show tables')->only('index','show');
        $this->middleware('permission:add tables')->only('create','store');
        $this->middleware('permission:edit tables')->only('edit','update');
        $this->middleware('permission:delete tables')->only('destroy');
    }

    public function index()
    {
        $tableIds = Table::where('restaurant_id', auth()->user()->restaurant_id)->pluck('id')->toArray();
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'user_id');
        $params['user_id'] = $params['user_id'] ?? $user->id;
        $params['restaurant_id'] = $user->restaurant_id ?? 0;
        $tables = (new TableRepository())->allPlan($params);
        return view('restaurant.tables.index', ['tables' => $tables]);
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->restaurant_id == null) {
            return redirect('restaurants')->with(['Error' => __('system.dashboard.create_restro')]);
        }

        return view('restaurant.tables.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $vendor_id = ($user->user_type == 2) ? $user->created_by : $user->id;

            $data = $request->only('name', 'no_of_capacity', 'position', 'status', 'lang_table_name');
            $data['user_id'] = $vendor_id;
            $data['restaurant_id'] = $user->restaurant_id;

            Table::create($data);

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.tables.menu')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }

        return redirect()->route('restaurant.tables.index');
    }


    public function edit(Table $table)
    {
        $user = auth()->user();

        if ($user->restaurant_id == null) {
            return redirect('restaurants')->with(['Error' => __('system.dashboard.create_restro')]);
        }

        return view('restaurant.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $vendor_id = ($user->user_type == 2) ? $user->created_by : $user->id;

            $data = $request->only('name', 'no_of_capacity', 'position', 'status', 'lang_table_name');
            $data['user_id'] = $vendor_id;
            $data['restaurant_id'] = $user->restaurant_id;

            $table->fill($data)->save();

            DB::commit();
            $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.tables.menu')]));

            if ($request->back) {
                return redirect($request->back);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }

        return redirect()->route('restaurant.tables.index');
    }

    public function destroy(Request $request,Table $table)
    {
        Waiter::where('table_id',$table->id)->delete();
        $table->delete();

        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.tables.menu')]));
        return redirect()->back();
    }
}
