<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserRequest;
use App\Service\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    public function getUsers(Request $request){

        if($request->statuscode || $request->currency || $request->amount || $request->date)
            return $this->userService->filter($request,['*'],['transections']);
        else
            return $this->userService->all(['*'],['transections']);
    }

    public function addUsers(UserRequest $request){
        return $this->userService->store($request->all());
    }
}
