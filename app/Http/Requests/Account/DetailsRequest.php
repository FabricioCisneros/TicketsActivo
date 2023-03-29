<?php

namespace App\Http\Requests\Account;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class DetailsRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id],
            'avatar' => ['image', 'max:1000', 'dimensions:ratio=1/1']
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
            'name.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('name'), 'max' => 255]),

            'email.required' => __('El campo :attribute es requerido', ['attribute' => __('email')]),
            'email.email' => __('El campo :attribute debe ser un email valido', ['attribute' => __('email')]),
            'email.max' => __('El campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('email'), 'max' => 255]),
            'email.unique' => __('El campo :attribute ya esta en uso', ['attribute' => __('email')]),

            'avatar.image' => __('El archivo debe ser una imagen', ['attribute' => __('avatar')]),
            'avatar.max' => __('El archivo :attribute no debe ser mayor a :max kilobytes', ['attribute' => __('avatar'), 'max' => 1000]),
            'avatar.dimensions' => __('el archivo :attribute debe tener dimensiones validas', ['attribute' => __('avatar')])
        ];
    }
}
