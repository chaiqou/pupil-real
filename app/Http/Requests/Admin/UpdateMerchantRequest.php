<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'merchant_id' => '',
            'school_id' => '',
            'merchant_nick' => ['required'],
            'company_legal_name' => ['required'],
            'company_name' => ['required'],
            'street_address' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'state' => '',
            'zip' => ['required'],
            'VAT' => ['required'],
        ];
    }
}
