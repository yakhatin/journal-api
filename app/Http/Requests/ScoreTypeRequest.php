<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoreTypeRequest extends FormRequest
{
    public $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Тип данных" является обязательным.',
            'description.required' => 'Поле "Описание типа данных" является обязательным.'
        ];
    }
}
