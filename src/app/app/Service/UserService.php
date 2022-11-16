<?php

namespace App\Service;

use App\Http\Resources\api\UserResource;
use App\Service\UserServiceInterface;
use App\Service\BaseService;
use App\Repository\UserRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserService extends BaseService implements UserServiceInterface
{
    use RespondsWithHttpStatus;
    protected $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    function all(array $columns=['*'],array $relations=[])
    {
        $users = $this->repo->all($columns,$relations);
        return $this->successWithData('data retrived successfully',UserResource::collection($users),200);
    }

    function filter($request,array $columns = ['*'], array $relations = []){
        if(in_array('transections',$relations))
        {
            $users = $this->repo->filter($request,$columns,$relations)->whereHas('transections',function($q) use($request){
                $q->where(function($query) use($request){
                    $this->filterCondations($query,$request);
                });
            })->with('transections',function($q) use($request){
                $q->where(function($query) use($request){
                    $this->filterCondations($query,$request);
                })->get();
            })
            ->get($columns);
        }else{
            $users = $this->repo->filter($request,$columns,$relations);
        }

        return $this->successWithData('data retrived successfully',UserResource::collection($users),200);
    }

    function store(array $data)
    {
        try{
            $users = json_decode(file_get_contents($data['file']), true);
            foreach($users['users'] as $user){
                $validator = Validator::make($user, [
                    'email'         => 'required|unique:users|email',
                    'balance'       => 'required',
                    'currency'      => 'required|string',
                    'created_at'    => 'required',
                    'id'            => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['message'=>'please check the data you enterd and not dublicate email'],422);
                }else{
                    $user_data = [
                        "balance"       => $user['balance'],
                        "currency"      => $user['currency'],
                        "email"         => $user['email'],
                        "created_at"    => Carbon::createFromFormat('d/m/Y', $user['created_at'])->format('Y-m-d'),
                        "id"            => $user['id']
                    ];
                    $this->repo->create($user_data);
                }
            }
            return $this->success('data saved successfully',200);
        }catch(Throwable $e){
            return $this->failure('something went wrong',500);
        }
    }

    function filterCondations($query,$request){
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
    }

}
