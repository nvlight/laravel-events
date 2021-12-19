<?php

namespace App\Http\Requests\Natpot;

use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends FormRequest
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

    public function messages()
    {
        return [
            'natpot_type.required' => 'Выберите тип потолка',
            'natpot_type.min' => 'Выберите тип потолка',
            'st1.required' => 'Сторона A обязательна для заполнения',
            'st2.required' => 'Сторона B обязательна для заполнения',
            'st3.required' => 'Сторона C обязательна для заполнения',
            'st4.required' => 'Сторона D обязательна для заполнения',
            'st1.min' => 'Минимальное значение 1',
            'st2.min' => 'Минимальное значение 1',
            'st3.min' => 'Минимальное значение 1',
            'st4.min' => 'Минимальное значение 1',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'natpot_type' => ['required','integer', 'min:1'],
            'st1' => ['required','integer','min:1'],
            'st2' => ['required','integer','min:1'],
            'st3' => ['required','integer','min:1'],
            'st4' => ['required','integer','min:1'],

            'chandeliers' => ['integer','min:0'],
            'fixtures' => ['integer','min:0'],
            'pipes' => ['integer','min:0'],
        ];
    }
}
