<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
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
            'token' => ['required', 'min:60', 'max:60'],
            'password' => ['required', 'min:6', 'confirmed']
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
            'token.required' => __('El campo :attribute es requerido', ['attribute' => __('token')]),
            'token.min' => __('El campo :attribute No debe ser menor a :max caracteres', ['attribute' => __('token'), 'max' => 60]),
            'token.max' => __('El campo :attribute No debe ser mayor a :max caracteres', ['attribute' => __('token'), 'max' => 60]),

            'password.required' => __('El campo :attribute es requerido', ['attribute' => __('password')]),
            'password.min' => __('El campo :attribute debe tener al menos :min caracteres', ['attribute' => __('password'), 'min' => 6]),
            'password.confirmed' => __('el campo :attribute de confirmacion no coincide', ['attribute' => __('password')])
        ];
    }
}
