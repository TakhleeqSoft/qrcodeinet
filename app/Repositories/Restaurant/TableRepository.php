<?php

namespace App\Repositories\Restaurant;

use App\Models\Table;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class TableRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Table::class;
    }

    public function allPlan($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['restaurant_id']), function ($query) use ($params, $table) {
            $query->where("$table.restaurant_id", $params['restaurant_id']);
        })->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->whereIn("$table.id", $params['table_id']);
                $query->where("$table.name", 'like', '%' . $params['filter'] . '%');

                // $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->get();;
    }
}
