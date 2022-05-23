<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequestStore extends FormRequest
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
            'category_id' => ['required','integer','min:1'],
            'type_id' =>     ['required','integer','min:1'],
            'date' =>        ['required','date'],
            'amount' =>      ['nullable','integer','min:0'],
            'description' => ['required','string','min:3','max:65535'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Категория должна быть заполнена',
            'category_id.integer' => 'Категория должна быть целым числом',
            'category_id.min' => 'Категория должна быть больше нуля',

            'type_id.required' => 'Тип должен быть заполнен',
            'type_id.integer' => 'Тип должен быть целым числом',
            'type_id.min' => 'Тип должен быть больше нуля',

            'amount.integer' => 'Сумма должна быть целым числом',
            'amount.min' => 'Сумма должна быть больше нуля',

            'description.required' => 'Описание должно быть заполнено',
            'description.string' => 'Описание должно быть текстом',
            'description.min' => 'Описание должно быть больше :min символов',
            'description.max' => 'Описание должно быть меньше :max символов',

            'date.required' => 'Дата обязательна для заполнения',
            'date.date' => 'Дата должны быть в формате даты!',
        ];
    }

}
