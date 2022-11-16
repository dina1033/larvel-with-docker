<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\UserResource;
use App\Service\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    public function getUsers(Request $request){
        if($request->statuscode || $request->currency || $request->amount || $request->date)
            $users =  $this->userService->filter($request,['*'],['transections']);
        else
            $users =  $this->userService->all(['*'],['transections']);

        return $users;
       return response()->json(UserResource::collection($users));
    }
}
