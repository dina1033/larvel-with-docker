<?php

namespace App\Service;

use App\Http\Resources\api\UserResource;
use App\Service\UserServiceInterface;
use App\Service\BaseService;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserService extends BaseService implements UserServiceInterface
{
    protected $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    function filter($request,array $columns = ['*'], array $relations = []){
        return $this->repo->filter($request,$columns,$relations);
    }

    function store(array $data)
    {
        $users = json_decode(file_get_contents($data['file']), true);
        foreach($users['users'] as $user){
            $validator = Validator::make($user, [
                'email'         => 'required|unique:users|email',
                'balance'       => 'required',
                'currency'      => 'required|string',
                'created_at'    => 'required',
                'id'            => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message'=>'please check the data you enterd and not dublicate email'],422);
            }
            $user_data = [
                "balance"       => $user['balance'],
                "currency"      => $user['currency'],
                "email"         => $user['email'],
                "created_at"    => Carbon::createFromFormat('d/m/Y', $user['created_at'])->format('Y-m-d'),
                "id"            => $user['id']
            ];
            $this->repo->create($user_data);
        }
    }

}
