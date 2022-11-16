<?php

namespace App\Repository;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function filter($request,array $columns = ['*'], array $relations = []);
}
