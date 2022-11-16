<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Resources\Json\JsonResource;

class TransectionResource extends JsonResource
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
            "paidAmount"                        =>  $this->paidAmount,
            "currency"                          =>  $this->currency,
            "parentEmail"                       =>  $this->parentEmail,
            "statusCode"                        =>  $this->statusCode,
            "parentIdentification"              =>  $this->parentIdentification,
            "paymentDate"                       =>  $this->created_at->format('Y-m-d'),
        ];
    }
}
