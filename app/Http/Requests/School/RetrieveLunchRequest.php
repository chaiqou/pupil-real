<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class RetrieveLunchRequest extends FormRequest
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
            'card_data' => 'required',
            'lunch_date' => 'required|date_format:Y.m.d',
        ];
    }
}
