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
            'type_id' => ['required','integer','min:1'],
            'date' => ['required','date'],
            'amount' => ['integer','min:0'],
            'description' => ['required','string','min:3','max:1111'],
        ];
    }
}
