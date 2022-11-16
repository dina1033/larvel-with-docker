<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repository\UserRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->whereHas('transections')->with($relations)->get($columns);
    }


    public function filter($request,array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->Filter($request)->get($columns);
    }

}
