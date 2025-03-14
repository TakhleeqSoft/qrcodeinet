<?php

namespace App\Repositories\Restaurant;

use App\Models\FoodCategory;
use App\Models\Testimonial;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class TestimonialRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Testimonial::class;
    }

    public function allTestimonial($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.title", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.testimonial_id", '=',  $params['filter']);
            });
        })->get();;
    }
}