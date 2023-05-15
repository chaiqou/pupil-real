<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class RetrieveLunchRequest extends FormRequest
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
            'card_data' => 'required',
            'lunch_date' => 'required|date_format:Y.m.d',
        ];
    }
}
