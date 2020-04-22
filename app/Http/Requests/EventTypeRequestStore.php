<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventTypeRequestStore extends FormRequest
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
            'name' => ['required', 'string', 'max:215', 'min:3'],
            'color' => ['required', 'string', 'regex:/^[a-f\d]{3,6}$/ui'],
        ];
    }
}
