<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /* public function authorize()
    {
        return false;
    } */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $data = json_decode($validator->errors(), true);
        $error = "";
        //error_log($data);
        foreach ($data as $key => $value) {
            //error_log($value[0]);
            $error .= $value[0] ." ";
        }
        
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'state' => 'error',
            'message' => $error,
            'levelNotification' => '2',
        ]));
    }
}
