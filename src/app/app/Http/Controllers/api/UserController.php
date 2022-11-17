<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\api\UserRequest;
use App\Service\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\api\UserResource;

class UserController extends ApiController
{

    private $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    public function getUsers(Request $request){

        $users = $this->userService->filter($request,['*'],['transections']);
        return $this->successWithData('data retrived successfully',UserResource::collection($users),200);

    }

    public function addUsers(UserRequest $request){
        try{
            $this->userService->store($request->all());
            return $this->success('data saved successfully',200);
        }catch(Throwable $e){
            return $this->failure('something went wrong',500);
        }
    } 
}
