<?php

namespace App\Http\Requests\Dashboard\Admin\UserRole;

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
            'name' => ['required', 'max:255', 'unique:user_roles,name'],
            'dashboard_access' => ['required'],
            'permissions' => ['array']
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
            'name.unique' => __('El campo :attribute ya fue tomado', ['attribute' => __('name')]),

            'dashboard_access.required' => __('El campo :attribute es requerido', ['attribute' => __('dashboard access')]),

            'permissions.array' => __('El campo :attribute debe ser un arreglo', ['attribute' => __('permissions')]),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $permissions = [];
        foreach ($this->get('permissions') as $key => $value) {
            if ($value) {
                $permissions[] = $key;
            }
        }
        $this->merge([
            'permissions' => $permissions,
        ]);
    }
}
