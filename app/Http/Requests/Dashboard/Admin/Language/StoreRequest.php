<?php

namespace App\Http\Requests\Dashboard\Admin\Language;

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
            'name' => ['required'],
            'locale' => ['required', 'min:1', 'max:5', 'unique:languages'],
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
            'name.max' => __('el campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            'locale.required' => __('El campo :attribute es requerido', ['attribute' => __('locale')]),
            'locale.min' => __('El campo :attribute debe tener al menos :min caracteres', ['attribute' => __('locale'), 'min' => 1]),
            'locale.max' => __('El campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('locale'), 'max' => 5]),
            'locale.unique' => __('El campo :attribute ya esta en uso', ['attribute' => __('locale')]),
        ];
    }
}
