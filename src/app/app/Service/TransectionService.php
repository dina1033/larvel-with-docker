<?php

namespace App\Service;
use App\Service\TransectionServiceInterface;
use App\Service\BaseService;
use App\Repository\TransectionRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TransectionService extends BaseService implements TransectionServiceInterface
{
    use RespondsWithHttpStatus;
    protected $repo;
    public function __construct(TransectionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    function store(array $data)
    {
        try{
            $transections = json_decode(file_get_contents($data['file']), true);
            foreach($transections['transactions'] as $transection){
                $validator = Validator::make($transection, [
                    'paidAmount'                      => 'required',
                    'Currency'                        => 'required|string',
                    'parentEmail'                     => 'required',
                    'statusCode'                      => 'required',
                    'paymentDate'                     => 'required',
                    'parentIdentification'            => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['message'=>'please check the data you enterd and not dublicate email'],422);
                }else{
                    $transection_data = [
                        "paidAmount"                => $transection['paidAmount'],
                        "currency"                  => $transection['Currency'],
                        "parentEmail"               => $transection['parentEmail'],
                        "statusCode"                => $transection['statusCode'],
                        "created_at"                => $transection['paymentDate'],
                        "parentIdentification"      => $transection['parentIdentification']
                    ];
                    $this->repo->create($transection_data);
                }
            }
            return $this->success('data saved successfully',200);
        }catch(Throwable $e){
            return $this->failure('something went wrong try again later',500);
        }
    }
}
