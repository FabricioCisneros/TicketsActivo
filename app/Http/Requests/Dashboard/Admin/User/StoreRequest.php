<?php

namespace App\Http\Requests\Dashboard\Admin\User;

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
            'email' => [ 'nullable','email', 'max:255', 'unique:users'],
            'status' => ['required'],
            'role_id' => ['required', 'exists:user_roles,id'],
            'password' => ['required', 'min:6']
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
            'name.max' => __('El campo :attribut no debe ser mayor a :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            
            'email.email' => __('El campo :attribute debe ser un email valido', ['attribute' => __('email')]),
            'email.max' => __('El campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('email'), 'max' => 255]),
            'email.unique' => __('El campo :attribute Ya esta en uso', ['attribute' => __('email')]),

            'status.required' => __('El campo :attribute es requerido', ['attribute' => __('status')]),

            'role_id.required' => __('El campo :attribute es requerido', ['attribute' => __('role')]),
            'role_id.exists' => __('El :attribute es un invalido', ['attribute' => __('role')]),

            'password.required' => __('El campo :attribute es requerido', ['attribute' => __('password')]),
            'password.min' => __('El campo :attribute debe tener al menos :min caracteres', ['attribute' => __('password'), 'min' => 6]),
        ];
    }
}
