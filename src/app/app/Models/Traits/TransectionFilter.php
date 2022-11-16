<?php
namespace App\Models\Traits;


trait TransectionFilter
{
    public function scopeTransectionFilter($query , $request){

        if($request->statuscode){
            $query->when($request->statuscode == 'authorized', function ($q) {
                return $q->where('statuscode',1);
            });
            $query->when($request->statuscode == 'decline', function ($q) {
                return $q->where('statuscode',2);
            });
            $query->when($request->statuscode == 'refunded', function ($q) {
                return $q->where('statuscode',3);
            });
        }
        if($request->currency){
            $query->where('currency',$request->currency);
        }
        if($request->amount){
            $amount_range = explode(',',$request->amount);
            $query->whereBetween('paidAmount',$amount_range);
        }
        if($request->date){
            $date_range = explode(',',$request->date);
            $query->whereBetween('created_at',$date_range);
        }
            

        return $query;
    }



}