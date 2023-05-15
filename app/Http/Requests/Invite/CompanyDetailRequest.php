<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDetailRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'merchant_nick' => ['required'],
            'company_name' => ['required'],
            'company_legal_name' => ['required'],
            'business_type' => ['required'],
            'street_address' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'state' => '',
            'zip' => ['required'],
            'VAT' => ['required'],
        ];
    }
}
