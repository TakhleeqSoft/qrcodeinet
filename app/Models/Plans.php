<?php

namespace App\Models;

use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plans extends Model implements Searchable
{

    use HasFactory, Sortable;

    public $table = 'plans';
    public $primaryKey = 'plan_id';


    protected $fillable = [
        'plan_id',
        'title',
        'amount',
        'type',
        'table_limit',
        'restaurant_limit',
        'item_limit',
        'staff_limit',
        'food_limit',
        'status',
        'item_unlimited',
        'staff_unlimited',
        'restaurant_unlimited',
        'food_unlimited',
        'paypal_plan_id',
        'paypal_product_id',
        'stripe_product_id',
        'table_unlimited',
        'lang_plan_title'
    ];

    public $sortable = [
        'plan_id',
        'title',
        'amount',
        'type',
    ];

    protected $casts = [
        'lang_plan_title' => "array",
    ];

    public function getLocalTitleAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->title;
        } else {
            return $this->lang_plan_title[app()->getLocale()] ?? $this->title;
        }
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('restaurant.plan.edit',  $this->plan_id);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
