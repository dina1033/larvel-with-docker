<?php

namespace App\Service;
use App\Service\ServiceInterface;

interface UserServiceInterface extends ServiceInterface
{
    public function filter($request,array $columns = ['*'], array $relations = []);
}
