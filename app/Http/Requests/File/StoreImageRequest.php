<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'file' => ['required', 'image', 'max:5000'],
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
            'file.required' => __('El campo :attribute es requerido', ['attribute' => __('file')]),
            'file.image' => __('El campo :attribute debe ser una imagen', ['attribute' => __('file')]),
            'file.max' => __('El archivo :attribute debe pesar entre :min y :max kilobytes', ['attribute' => __('file'), 'max' => 5000]),
        ];
    }
}
