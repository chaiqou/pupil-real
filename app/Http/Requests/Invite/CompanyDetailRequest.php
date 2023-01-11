<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDetailRequest extends FormRequest
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
            'merchant_nick' => 'required',
            'company_name' => 'required',
            'company_legal_name' => 'required',
            'business_type' => 'required',
            'street_address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => '',
            'zip' => 'required',
            'VAT' => 'required',
        ];
    }
}
