<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParserParseRequest extends FormRequest
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
            'selected.*' => 'required|regex:(.sql)',
            'format' => 'in:xml,txt,csv'
        ];
    }

    public function messages()
    {
        return [
            'selected.required' => 'select!'
        ];
    }
}
