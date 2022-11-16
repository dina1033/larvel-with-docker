<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repository\UserRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->whereHas('transections')->with($relations)->get($columns);
    }


    public function filter($request,array $columns = ['*'], array $relations = []): Collection
    {
        if(in_array('transections',$relations))
        {
            return $this->model->whereHas('transections',function($q) use($request){
                $q->where(function($query) use($request){
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
                        $query->whereBetween('paidAmount',$request->amount);
                    }
                    if($request->date){
                        $query->whereBetween('created_at',$request->date);
                    }
                });
            })->with('transections')
            ->get($columns);
        }
    }

}
