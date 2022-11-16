<?php

namespace App\Service;
use App\Service\UserServiceInterface;
use App\Service\BaseService;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class UserService extends BaseService implements UserServiceInterface
{
    protected $repo;
    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    function all(array $columns=['*'],array $relations=[])
    {

        return $this->repo->all($columns,$relations);
    }

    function filter($request,array $columns = ['*'], array $relations = []){
        return $this->repo->filter($request,$columns,$relations);
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
