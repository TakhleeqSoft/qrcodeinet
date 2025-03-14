<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSetting extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'default_food_image',
        'default_category_image',
        'default_currency',
        'default_currency_symbol',
        'default_currency_position',
        'pusher_appid',
        'pusher_secret',
        'pusher_cluster',
        'pusher_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('user_type', 3);
    }
}
