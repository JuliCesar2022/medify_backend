<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicamentoRequest extends FormRequest
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
            //

            'medicamento'             => 'required|string',
            'tipomedicaemnto'        => 'required|string',
            'dosis'            => 'required',
            'frecuencia'          => 'required',
            'iniciotratamiento'         => 'required',
            'fintratamiento'  => 'required',
            'recordar'=> "required",
            'usuario_id'=> "required"
        ];
    }
}
