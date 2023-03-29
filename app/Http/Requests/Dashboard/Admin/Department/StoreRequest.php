<?php

namespace App\Http\Requests\Dashboard\Admin\Department;

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
            'agents' => ['required_if:all_agents,false'],
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

            'agents.required_if' => __('El campo :attribute debe tener al menos :min items', ['attribute' => __('agents'), 'min' => 1]),
        ];
    }
}
