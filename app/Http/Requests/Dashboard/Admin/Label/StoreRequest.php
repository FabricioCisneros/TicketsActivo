<?php

namespace App\Http\Requests\Dashboard\Admin\Label;

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
            'name' => ['required', 'max:255'],
            'color' => ['required', 'regex:/^#(\d|a|b|c|d|e|f){6}$/i'],
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
            'name.required' => __('el campo :attribute es requerido', ['attribute' => __('name')]),
            'name.max' => __('el campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            'color.required' => __('El campo :attribute es requerido', ['attribute' => __('color')]),
            'color.regex' => __('El campo :attribute tiene un formato invalido', ['attribute' => __('color')]),
        ];
    }
}
