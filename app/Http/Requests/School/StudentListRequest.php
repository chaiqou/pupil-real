<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class StudentListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'public_key' => 'required',
            'signature' => 'required|size:128',
            'per_page' => 'required|integer',
            'page' => 'required|integer',
            'mode' => 'required|in:all,search',
            'search_key' => 'string',
            'search_value' => 'string',
        ];
    }
}
