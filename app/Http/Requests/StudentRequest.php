<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public $rules = [
        'name' => 'required|string',
        'group_id' => 'required|int'
    ];

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
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "ФИО студента" является обязательным.',
            'group_id.required' => 'Поле "Группа" является обязательным.'
        ];
    }
}
