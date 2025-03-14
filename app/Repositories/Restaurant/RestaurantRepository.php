<?php

namespace App\Repositories\Restaurant;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class RestaurantRepository.
 */
class RestaurantRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Restaurant::class;
    }

    public function getUserRestaurantsQuery($params)
    {


        $data = $this->model->with('users')->when(isset($params['user_id']), function ($query) use ($params) {
            $query->whereHas('users', function ($q) use ($params) {
                $q->where('user_id', $params['user_id']);
            });
        })->when(isset($params['assigned_restaurant']), function ($query) use ($params) {
            if (count($params['assigned_restaurant'])>0){
                $query->whereIn('id',$params['assigned_restaurant']);
            }
        })->admin($params);
        return $data;
    }

    public function getUserRestaurants($params)
    {
        $table = $this->model->getTable();

        $restaurants = $this->getUserRestaurantsQuery($params)->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {

            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.name", 'like', '%' . $params['filter'] . '%')
                    ->orWhere("$table.type", 'like', '%' . $params['filter'] . '%')
                    ->orWhere("$table.phone_number", 'like', $params['filter'] . '%')
                    ->orWhere("$table.id", '=', $params['filter'])
                    ->orWhere("$table.contact_email", 'like', '%' . $params['filter'] . '%');
            });
        })->select(
            "$table.name",
            "$table.type",
            "$table.logo",
            "$table.cover_image",
            "$table.theme",
            "$table.contact_email",
            "$table.address",
            "$table.phone_number",
            "$table.created_at",
            "$table.id",
            "$table.user_id",
            "$table.language",
            "$table.slug",
        )->paginate($params['par_page']);

        return $restaurants;
    }

    public function getUserRestaurantsDetails($params)
    {
        $table = $this->model->getTable();
        $restaurants = $this->getUserRestaurantsQuery($params)->when(isset($params['except_restaurant_id']), function ($q) use ($params) {
            $q->where('id', '!=', $params['except_restaurant_id']);
        })->select(
            "$table.name",
            "$table.logo",
            "$table.cover_image",
            "$table.theme",
            "$table.id",
            "$table.user_id",
            "$table.language",
            "$table.created_at",
        );
        if (isset($params['latest'])) {
            $restaurants = $restaurants->orderBy('id', 'desc');
        }
        if (isset($params['recodes'])) {
            $restaurants = $restaurants->limit($params['recodes'])->get();
        } else {
            $restaurants = $restaurants->get();
        }
        return $restaurants;
    }

    public function getAllRestaurantsWithIdAndName($params = [])
    {
        $table = $this->model->getTable();
        $user = auth()->user();
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $params['user_id'] = $user->created_by;
        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $params['user_id'] = $user->id;
        }
        $restaurants = $this->getUserRestaurantsQuery($params)->when(isset($params['restaurant_id']), function ($query) use ($params) {
            $query->orderByRaw("FIELD(id," . $params['restaurant_id'] . " ) asc");
        })->pluck('name', 'id');

        return $restaurants->toArray();
    }

    public function getCountRestaurants($params = [])
    {
        $table = $this->model->getTable();

        $restaurants = $this->getUserRestaurantsQuery($params)->when(isset($params['restaurant_id']), function ($query) use ($params) {
            $query->orderByRaw("FIELD(id," . $params['restaurant_id'] . " ) asc");
        });

        return $restaurants->count('id');
    }

    public function getVendorsList($params = [])
    {
        $vendors=User::where('user_type',User::USER_TYPE_VENDOR)->select(DB::raw('CONCAT(first_name," ",last_name) AS full_name'),'id')->where('status',1)->orderBy('first_name','asc')->pluck('full_name','id');
        return $vendors->toArray();
    }
}
