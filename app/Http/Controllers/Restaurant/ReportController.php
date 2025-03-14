<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Transactions;
use App\Models\User;
use App\Models\Plans;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Transactions::with(['user' => function($userQuery){
            $userQuery->select('id','first_name','last_name');
        }])->hasFilter()
        ->select( "id","user_id","plan_id",'amount',DB::raw('sum(amount) as total_amount'))
        ->orderBy('id','desc')
        ->groupBy('user_id')
        ->get();

        $users = User::select('id','first_name','last_name')->where('user_type',User::USER_TYPE_VENDOR)->orderBy('first_name')->get();
        return view('restaurant.report.index',compact('reports','users'));
    }
}
