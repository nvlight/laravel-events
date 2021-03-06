<?php

namespace App\Http\Requests\Evento;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentUpdateRequest extends FormRequest
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
        $file = [
            'size' => [
                'min' => 0,
                'max' => 5120
            ],
            'mimes' => [
                'jpg', 'jpeg', 'png', 'webp', 'svg', 'gif',
                'doc', 'docx', 'xls', 'xlsx', 'pdf', 'djvu', 'txt',
                'zip', 'rar'
            ],
        ];

        return [
            'evento_id' => ['required', 'int', 'min:0'],
            'file' => 'nullable|file' .
                '|min:' . $file['size']['min'] .
                '|max:' . $file['size']['max'] .
                '|mimes:' . implode(',', $file['mimes']),
        ];
    }
}
