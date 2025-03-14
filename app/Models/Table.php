<?php

namespace App\Models;

use App\Models\Restaurant;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory, Sortable;

    public $table = 'tables';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'no_of_capacity',
        'position',
        'status',
        'lang_table_name'
    ];

    public $sortable = [
        'user_id',
        'restaurant_id',
        'name',
        'no_of_capacity',
        'position',
    ];

    protected $casts = [
        'lang_table_name' => "array",
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
    public function waiters()
    {
        return $this->hasOne(Waiter::class, 'table_id', 'id');
    }
}
