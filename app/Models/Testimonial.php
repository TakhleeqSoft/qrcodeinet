<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory, Sortable;

    public $table = 'testimonials';
    public $primaryKey = 'testimonial_id';

    protected $fillable = [
        'testimonial_id',
        'name',
        'company',
        'description',
        'testimonial_image',
    ];

    public $sortable = [
        'testimonial_id',
        'name',
        'company',
        'description',
    ];


    public function setTestimonialImageAttribute($value)
    {
        $this->attributes['testimonial_image'] = uploadFile($value, 'testimonial_image');
    }

    public function getTestimonialImageAttribute()
    {
        return getFileUrl($this->attributes['testimonial_image']);
    }
}
