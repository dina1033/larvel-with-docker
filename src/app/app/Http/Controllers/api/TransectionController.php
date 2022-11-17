<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\api\TransectionRequest;
use App\Service\TransectionServiceInterface;

class TransectionController extends ApiController
{
    private $transectionService;
    public function __construct(TransectionServiceInterface $transectionService)
    {
        $this->transectionService = $transectionService;
    }


    public function addTransections(TransectionRequest $request){
        try{
            $this->transectionService->store($request->all());
            return $this->success('data saved successfully',200);
        }catch(Throwable $e){
            return $this->failure('something went wrong try again later',500);
        }

    }
}
