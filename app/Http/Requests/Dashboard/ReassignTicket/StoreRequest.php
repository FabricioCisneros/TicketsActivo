<?php

namespace App\Http\Requests\Dashboard\ReassignTicket;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'reason'=>['required','max:225']
        ];
    }

    public function messages(){
        return[
            'reason.required' =>__('el campo :attribute no puede estar vacio',['attribute'=>__('razon')]),
            'reason.max' =>__('el campo :attribute no puede ser mayor a :max',['attribute'=>__('razon'),'max'=> 255])
        ];
    }
}
