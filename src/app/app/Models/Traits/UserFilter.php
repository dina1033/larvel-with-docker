<?php
namespace App\Models\Traits;

trait UserFilter
{
    public function scopeFilter($query , $request){
        return $query->whereHas('transections',function($q) use($request){
            $q->TransectionFilter($request);
        })
        ->with(['transections'=>function($q) use($request){
           $q->TransectionFilter($request)->get();
        }]);
        
    }
}