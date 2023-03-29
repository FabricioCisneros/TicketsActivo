<?php

namespace App\Http\Requests\Dashboard\Admin\Priority;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'value' => ['required', 'integer'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('El campo :attribute es requerido', ['attribute' => __('name')]),
            'name.max' => __('El campo :attribute no debe ser mayor a  :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            'value.required' => __('El campo :attribute es requerido', ['attribute' => __('value')]),
            'value.integer' => __('El campo :attribute debe ser un numero entero', ['attribute' => __('value')]),
        ];
    }
}
