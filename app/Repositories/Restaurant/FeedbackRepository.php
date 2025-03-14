<?php

namespace App\Repositories\Restaurant;

use App\Models\Feedback;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class FeedbackRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Feedback::class;
    }

    public function allFeedback($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['restaurant_id']), function ($query) use ($params, $table) {
            $query->where("$table.restaurant_id", $params['restaurant_id']);
        })->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.name", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->with('restaurant', 'user')->paginate($params['par_page']);
    }
}
