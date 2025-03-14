<?php

namespace App\Models;

use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Waiter extends Model
{
    use HasFactory, Sortable;

    public $table = 'waiters';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'table_id',
        'status',
    ];

    public $sortable = [
        'user_id',
        'restaurant_id',
        'table_id',
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id');
    }

    public function scopeHasFilter($query)
    {
        $sortBy = request()->sort;
        if (!empty($sortBy)) {
            $order = request()->direction ?? 'desc';
            if ($sortBy == 'id') {
                $query->orderBy('id', $order);
            } else if ($sortBy === 'restaurant_id') {
                $query->join('restaurants', 'restaurants.id', '=', 'waiters.restaurant_id')->orderBy('restaurants.name', $order);
            } else if ($sortBy === 'table_name') {
                $query->join('tables', 'tables.id', '=', 'waiters.table_id')->orderBy('tables.name', $order);
            }else if ($sortBy === 'no_of_capacity') {
                $query->join('tables', 'tables.id', '=', 'waiters.table_id')->orderBy('tables.no_of_capacity', $order);
            }
        }
    }
}
