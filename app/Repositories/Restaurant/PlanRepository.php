<?php

namespace App\Repositories\Restaurant;

use App\Models\FoodCategory;
use App\Models\Plans;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class PlanRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Plans::class;
    }

    public function allPlan($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.title", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.plan_id", '=',  $params['filter']);
            });
        })->get();;
    }
}
