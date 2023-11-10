<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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

            'email'            => [
                'required',
                'email',
                Rule::unique('users')->ignore(Request('user_id'), 'id')
            ],

            'photo_profile'    => 'mimes:png,jpg,jpeg',
            "user_id"          => 'required'

        ];
    }
}
