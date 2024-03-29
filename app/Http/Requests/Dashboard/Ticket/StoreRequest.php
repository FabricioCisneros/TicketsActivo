<?php

namespace App\Http\Requests\Dashboard\Ticket;

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
            'user_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'body' => ['required'],
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
            'user_id.required' => __('el campo :attribute es requerido', ['attribute' => __('customer')]),
            'user_id.exists' => __('El campo :attribute es invalido', ['attribute' => __('customer')]),

            'subject.required' => __('El campo :attribute es requerido', ['attribute' => __('subject')]),
            'subject.max' => __('El campo :attribute debe tener un maximo de :max caracteres', ['attribute' => __('subject'), 'max' => 255]),

            'department_id.required' => __('El campo :attribute es requerido', ['attribute' => __('department')]),
            'department_id.exists' => __('El campo :attribute es invalido', ['attribute' => __('department')]),

            'status_id.required' => __('El campo :attribute es requerido', ['attribute' => __('status')]),
            'status_id.exists' => __('El :attribute es invalido', ['attribute' => __('status')]),

            'priority_id.required' => __('El campo :attribute es requerido', ['attribute' => __('priority')]),
            'priority_id.exists' => __('El :attribute es invalido', ['attribute' => __('priority')]),

            'body.required' => __('El campo :attribute es requerido', ['attribute' => __('body')]),
        ];
    }
}
