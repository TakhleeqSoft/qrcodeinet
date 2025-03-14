<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    public $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_method',
        'payment_type',
        'start_date',
        'expiry_date',
        'is_current',
        'details',
        'remark',
        'amount',
        'type',
        'table_limit',
        'restaurant_limit',
        'item_limit',
        'status',
        'staff_limit',
        'item_unlimited',
        'restaurant_unlimited',
        'staff_unlimited',
        'table_unlimited',
        'transaction_id',
        'subscription_id',
        'json_response',
    ];

    public function scopehasFilter($query){
        if(!empty(request()->user_id)){
            $query->where('user_id',request()->user_id);
        }

        if(!empty(request()->plan_id)){
            $query->where('plan_id',request()->plan_id);
        }

        if(!empty(request()->from_date)){
            $query->whereDate('start_date',request()->from_date);
        }

        if(!empty(request()->to_date)){
            $query->whereDate('expiry_date',request()->to_date);
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function plan(){
        return $this->belongsTo(Plans::class,'plan_id','plan_id');
    }
}
