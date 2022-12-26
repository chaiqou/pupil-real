<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class ClaimLunchRequest extends FormRequest
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
            'lunch_id' => 'required',
            'lunch_date' => 'required|date_format:Y.m.d',
            'claim_name' => 'required',
            'claim_date' => 'required|date_format:Y.m.d H:i:s',
        ];
    }
}
