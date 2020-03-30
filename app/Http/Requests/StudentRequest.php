<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string',
            'group_id' => 'required|int'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "ФИО студента" является обязательным.',
            'group_id.required' => 'Поле "Группа" является обязательным.'
        ];
    }
}
