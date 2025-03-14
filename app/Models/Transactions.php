<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    public $table = 'transactions';
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'transaction_id',
        'user_id',
        'plan_id',
        'subscription_id',
        'details',
        'payment_response',
        'amount'
    ];

    public $sortable = [
        'id',
        'transaction_id',
        'user_id',
        'plan_id',
        'subscription_id',
        'details',
        'payment_response',
        'amount'
    ];

    public function plan(){
        return $this->belongsTo(Plans::class,'plan_id','plan_id');
    }
    public function subscription(){
        return $this->belongsTo(Subscriptions::class,'subscription_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function scopehasFilter($query){
        if(!empty(request()->user_id)){
            $query->where('user_id',request()->user_id);
        }

        if(!empty(request()->plan_id)){
            $query->where('plan_id',request()->plan_id);
        }

        if(!empty(request()->from_date) && !empty(request()->to_date)){
            $query->whereBetween(\DB::raw('DATE(created_at)'), [request()->from_date, request()->to_date]);
        }else{

            if(!empty(request()->from_date)){
                $query->whereDate('created_at',request()->from_date);
            }
            if(!empty(request()->to_date)){
                $query->whereDate('created_at',request()->to_date);
            }
        }


    }
}
