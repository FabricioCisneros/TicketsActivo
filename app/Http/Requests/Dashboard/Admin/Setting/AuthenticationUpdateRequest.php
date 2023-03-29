<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationUpdateRequest extends FormRequest
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
            'app_user_registration' => ['required', 'boolean'],
            'app_default_role' => ['required', 'exists:user_roles,id'],
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
            'app_user_registration.required' => __('El campo :attribute es requerido', ['attribute' => __('user registration')]),
            'app_user_registration.boolean' => __('El campo :attribute debe ser verdadero o falso', ['attribute' => __('user registration')]),

            'app_default_role.required' => __('El campo :attribute es requerido', ['attribute' => __('default role')]),
            'app_default_role.exists' => __('El rol :attribute es invalido', ['attribute' => __('default role')]),
        ];
    }
}
