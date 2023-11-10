<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'             => 'required|string',
            'apellido'        => 'required|string',
            'email'            => 'required|email|unique:users',
            'type_document_id'          => 'required|numeric|min:1',
            'number_document'         => 'required|unique:users|numeric',
            'photo_profile_url'  => '',
            'password'=> "required"
        
        ];
    }
}
