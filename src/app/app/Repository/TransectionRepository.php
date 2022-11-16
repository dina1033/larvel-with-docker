<?php

namespace App\Repository;

use App\Models\Transection;
use Illuminate\Database\Eloquent\Collection;
use App\Repository\TransectionRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class TransectionRepository extends BaseRepository implements TransectionRepositoryInterface
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
    public function __construct(Transection $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->withCount($relations)->orderBy('id','desc')->get($columns);
    }

    public function getEventsBySubscribtion(array $columns = ['*'],array $relations = [], $sub_id){
        return $this->model->withCount($relations)->orderBy('id','desc')->get($columns);
    }

    public function changeStatus(){
        $events=$this->model->where('end_date',date('Y-m-d'))->orwhere('end_date','<',date('Y-m-d'))->get();
        if($events != '[]') {
            foreach ($events as $event) {
                $event_status = $this->model->find($event->id);
                $event_status->status = 'complete';
                $event_status->save();
            }
        }
    }

}
