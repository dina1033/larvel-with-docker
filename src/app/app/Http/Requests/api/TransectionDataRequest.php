<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransectionDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [           
            'transections.*.paidAmount'                      => 'required',
            'transections.*.Currency'                        => 'required|string',
            'transections.*.parentEmail'                     => 'required',
            'transections.*.statusCode'                      => 'required',
            'transections.*.paymentDate'                     => 'required',
            'transections.*.parentIdentification'            => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response(['errors'=>['message'=>$validator->errors(), 'status'=>false]],422));
    }
}
