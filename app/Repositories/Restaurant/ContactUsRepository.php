<?php

namespace App\Repositories\Restaurant;

use App\Models\ContactUs;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class ContactUsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ContactUs::class;
    }

    public function allContactUs($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.id", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->get();;
    }
}
