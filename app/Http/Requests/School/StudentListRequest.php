<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class StudentListRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'public_key' => 'required',
            'signature' => 'required|size:128',
            'per_page' => 'required|integer',
            'page' => 'required|integer',
            'mode' => 'required|in:all,search',
            'search_key' => 'string',
            "search_value" => 'string'
        ];
    }
}
