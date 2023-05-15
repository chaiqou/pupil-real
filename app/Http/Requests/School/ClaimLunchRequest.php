<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class ClaimLunchRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'public_key' => 'required',
            'signature' => 'required|size:128',
            'lunch_id' => 'required',
            'lunch_date' => 'required|date_format:Y.m.d',
            'claim_name' => 'required',
            'claim_date' => 'required|date_format:Y.m.d H:i:s',
        ];
    }
}
