<?php

namespace App\Repositories\Restaurant;

use App\Models\CmsPage;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class CmsPageRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return CmsPage::class;
    }

    public function allCmsPage($params)
    {
        $table = $this->model->getTable();
        return $this->model->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.title", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->get();;
    }
}
