<?php

namespace App\Service;
use App\Service\TransectionServiceInterface;
use App\Service\BaseService;
use App\Repository\TransectionRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class TransectionService extends BaseService implements TransectionServiceInterface
{
    protected $repo;
    public function __construct(TransectionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    function all(array $columns=['*'],array $relations=[])
    {
        $token=Session::get('token');
        $subscribtions = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->get('http://license.aictec.com/api/subscriptions');

        $subscribtion_id=[];
        foreach(json_decode($subscribtions) as $subscribtion){
            $subscribtion_id[]=$subscribtion->id;
        }
        $events=$this->repo->all($columns,$relations)->whereIn('subscribtion_id',$subscribtion_id);
        return $events;
    }

    function store(array $data)
    {
        $user=$this->sub->getSubscribtion($data['user_id']);

        $response = Http::post('http://license.aictec.com/api/login',[
            'email' => $user->email,
            'password' =>$user->key,
        ]);
        $respons_data= json_decode($response->getBody());
        if($response->successful()){
            $subscribtions = Http::withHeaders([
                'Authorization' => 'Bearer '.$respons_data->token,
            ])->get('http://license.aictec.com/api/subscription/verify',[
                'id'=>$data['subscribtion_id'],
            ]);
            $subscribtion_data=json_decode($subscribtions->getBody());
            if($subscribtion_data->message =='Valid Subscription'){
                unset($data['user_id']);
                return $this->repo->create($data);
            }else{
                return 'sorry the subscribtion is invaild';
            }
        }
    }

}
