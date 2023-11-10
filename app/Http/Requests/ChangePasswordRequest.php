<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $password
 */
class ChangePasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|numeric',
            'phone' => 'required|not_exists:users,phone|numeric',
            'password' => 'required|string|min:8|confirmed'
        ];
    }
}

