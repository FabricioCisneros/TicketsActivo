<?php

namespace App\Http\Requests\Dashboard\Admin\User;

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
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$this->get('id')],
            'status' => ['required'],
            'role_id' => ['required', 'exists:user_roles,id'],
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
            'name.max' => __('El campo :attribute no debe tener mas de :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            'email.required' => __('El campo :attribute es requerido', ['attribute' => __('email')]),
            'email.email' => __('El campo :attribute debe tener', ['attribute' => __('email')]),
            'email.max' => __('El campo :attribute no debe ser mayor a  :max caracteres', ['attribute' => __('email'), 'max' => 255]),
            'email.unique' => __('El campo :attribute ya esta en uso', ['attribute' => __('email')]),

            'status.required' => __('El campo :attribute es requerido', ['attribute' => __('status')]),

            'role_id.required' => __('El campo :attribute es requerido', ['attribute' => __('role')]),
            'role_id.exists' => __('el campo :attribute es invalido', ['attribute' => __('role')]),
        ];
    }
}
