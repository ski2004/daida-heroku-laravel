<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegister extends FormRequest
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
            'email' => 'email|required|unique:users',
            'name' => 'required|string',
            'password' => 'required',
        ];
    }

    /**
     * failedValidation
     *
     * @param  Illuminate\Contracts\Validation\Validator $validator
     * @return void
     * 
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        $responseData = $validator->errors();
        $response = response()->json($responseData, 422);
        throw new HttpResponseException($response);
    }
}
