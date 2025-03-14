<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUs extends Model
{
    use HasFactory, Sortable;

    public $table = 'contact_us';
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'email',
        'message',
    ];

    public $sortable = [
        'id',
        'name',
        'email',
        'message',
    ];
}
