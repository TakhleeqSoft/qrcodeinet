<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantType extends Model
{
    use HasFactory;
    protected $table = 'restaurant_types';

    protected $fillable = [
        'id',
        'type',
        'lang_restaurant_type',
    ];
    protected $casts = [
        'lang_restaurant_type' => "array",
    ];
    public function getLocalNameAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->type;
        } else {
            return $this->lang_restaurant_type[app()->getLocale()] ?? $this->type;
        }
    }
}
