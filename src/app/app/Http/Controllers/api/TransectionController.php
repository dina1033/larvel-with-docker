<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\TransectionRequest;
use App\Service\TransectionServiceInterface;
use Illuminate\Http\Request;

class TransectionController extends Controller
{
    private $transectionService;
    public function __construct(TransectionServiceInterface $transectionService)
    {
        $this->transectionService = $transectionService;
    }


    public function addTransections(TransectionRequest $request){
        return $this->transectionService->store($request->all());
    }
}
