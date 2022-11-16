<?php

namespace App\Http\Resources\api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                                =>  $this->id,
            "email"                             =>  $this->email,
            "balance"                           =>  $this->balance,
            "currency"                          =>  $this->currency,
            "created_at"                        =>  $this->created_at->format('d/m/Y'),
            'transections'                      =>  TransectionResource::collection($this->transections) ,
        ];
    }
}
