<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
{

    public $rules = [
        'name' => 'required|string'
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
            'name.required' => 'Поле "Наименование задания" является обязательным.'
        ];
    }
}
