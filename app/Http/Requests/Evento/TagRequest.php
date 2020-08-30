<?php

namespace App\Http\Requests\Evento;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $img = [
            'dimensions' => [
                'min' => [
                    'width'  => 10,
                    'height' => 10
                ],
                'max' => [
                    'width'  => 100,
                    'height' => 100
                ],
            ],
            'size' => [
                'min' => 0,
                'max' => 2048
            ]
        ];
        return [
            'name' => ['required', 'string', 'max:105', 'min:2'],
            'color' => ['required', 'string', 'regex:/^#[a-f\d]{3,6}$/ui'],
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|min:' . $img['size']['min'] .
                '|max:' . $img['size']['max'] .
                '|dimensions:' .
                    'min_width=' . $img['dimensions']['min']['width'] . ',min_height=' . $img['dimensions']['min']['height'] .
                   ',max_width=' . $img['dimensions']['max']['width'] . ',max_height=' . $img['dimensions']['max']['height'],
        ];
    }
}
