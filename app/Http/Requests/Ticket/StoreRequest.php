<?php

namespace App\Http\Requests\Ticket;

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
            'subject' => ['required', 'max:255'],
            'department_id' => ['exclude_if:department_id,null', 'exists:departments,id'],
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
            'subject.required' => __('El campo :attribute es requerido', ['attribute' => __('subject')]),
            'subject.max' => __('El campo :attribute no debe tener mas de :max caracteres', ['attribute' => __('subject'), 'max' => 255]),

            'department_id.exists' => __('El item :attribute seleccionado es invalido', ['attribute' => __('department')]),

            'body.required' => __('El campo :attribute es requerido', ['attribute' => __('body')]),
        ];
    }
}
