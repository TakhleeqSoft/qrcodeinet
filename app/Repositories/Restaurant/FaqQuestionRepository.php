<?php

namespace App\Repositories\Restaurant;

use App\Models\FoodCategory;
use App\Models\FaqQuestion;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class FaqQuestionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return FaqQuestion::class;
    }

    public function allFaqQuestion($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.question", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->get();;
    }
}
