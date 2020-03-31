<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
{

    public $rules = [
        'name' => 'required|string',
        'group_id' => 'required|int',
        'subject_type' => 'required|int',
        'subject_id' => 'required|int'
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

    public function rules() {
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Наименование группы" является обязательным.',
            'group_id.required' => 'Поле "Идентификатор группы" является обязательным.',
            'subject_type.required' => 'Поле "Идентификатор типа предмета" является обязательным.',
            'subject_id.required' => 'Поле "Идентификатор предмета" является обязательным.'
        ];
    }
}
