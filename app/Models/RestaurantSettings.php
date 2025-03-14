<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantSettings extends Model
{
    use HasFactory;
    public $table = 'restaurant_settings';

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'allow_language_change',
        'allow_dark_light_mode_change',
        'allow_direction',
        'allow_show_allergies',
        'allow_show_calories',
        'allow_show_preparation_time',
        'allow_show_food_details_popup',
        'allow_show_banner',
        'allow_show_restaurant_name_address',
        'call_the_waiter',
        'display_language_page',
    ];
}
