<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public $rules = [
        'title' => 'required|string',
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
            'title.required' => 'Поле "Наименование предмета" является обязательным.',
        ];
    }
}
