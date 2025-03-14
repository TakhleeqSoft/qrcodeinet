<?php

namespace App\Repositories\Restaurant;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class UserRepository.
 */
class StaffRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function getRestaurantUsersQuery($params)
    {
        return $this->model->When(isset($params['user_id']), function ($q) use ($params) {
            $q->where('id', '!=', $params['user_id'])
                ->where('created_by',$params['created_by']);
        })->admin($params);
    }

    public function getRestaurantUser($params)
    {
        $user = $this->getRestaurantUsersQuery($params)->where('id', $params['id'])->first();
        return $user;
    }

    public function getRestaurantUsers($params)
    {
        $table = $this->model->getTable();
        $users = $this->getRestaurantUsersQuery($params)->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($q) use ($params, $table) {
                $q->where(DB::raw('CONCAT(' . $table . '.first_name, \' \', ' . $table . '.last_name)'), 'like', '%' . $params['filter'] . '%')
                    ->orWhere($table . '.email', 'like', '%' . $params['filter'] . '%')
                    ->orWhere($table . '.phone_number', 'like', $params['filter'] . '%')
                    ->orWhere($table . '.id', '=', $params['filter']);
            });
        })->where('user_type',2)
        ->select(
            "$table.first_name",
            "$table.last_name",
            "$table.email",
            "$table.phone_number",
            "$table.profile_image",
            "$table.id",
            "$table.created_at",
        );

        $users = $users->paginate($params['par_page']);
        return $users;
    }

    public function getRestaurantUsersCount($params)
    {
        $table = $this->model->getTable();
        $users = $this->getRestaurantUsersQuery($params)->count('id');
        return $users;
    }

    public function getRestaurantUsersRecodes($params)
    {
        $table = $this->model->getTable();
        $users = $this->getRestaurantUsersQuery($params)->orderBy('id', 'desc')->select(

            "$table.first_name",
            "$table.last_name",
            "$table.email",
            "$table.profile_image",
            "$table.phone_number",
            "$table.id",
            "$table.created_at",
        );
        if (isset($params['recodes'])) {
            $users = $users->limit($params['recodes']);
        }
        $users = $users->get();
        return $users;
    }
}
