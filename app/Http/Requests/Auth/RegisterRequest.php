<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', 'unique:users'],
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
            'name.required' => __('El campo :attribute es requerido', ['attribute' => __('name')]),
            'name.max' => __('El campo :attribute No debe ser mayor a :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            'email.required' => __('El campo :attribute es requerido', ['attribute' => __('email')]),
            'email.email' => __('El campo :attribute debe ser un email valido', ['attribute' => __('email')]),
            'email.max' => __('El campo :attribute No debe ser mayor a :max caracteres', ['attribute' => __('email'), 'max' => 255]),
            'email.unique' => __('El campo :attribute ya esta en uso', ['attribute' => __('email')]),

            'password.required' => __('El campo :attribute es requerido', ['attribute' => __('password')]),
            'password.min' => __('El campo :attribute debe tener como minimo :min caracteres', ['attribute' => __('password'), 'min' => 6]),
            'password.confirmed' => __('El campo :attribute de confirmacion no coincide', ['attribute' => __('password')])
        ];
    }
}
