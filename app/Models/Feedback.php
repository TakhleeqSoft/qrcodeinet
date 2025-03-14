<?php

namespace App\Models;

use App\Models\User;
use App\Models\Restaurant;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory, Sortable;

    public $table = 'feedbacks';
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'email',
        'message',
        'user_id',
        'restaurant_id'
    ];

    public $sortable = [
        'id',
        'name',
        'email',
        'restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
