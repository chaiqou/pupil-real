<?php

namespace App\Http\Requests\Admin;

use App\Rules\MinThreeWord;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'short_name' => ['required'],
            'full_name' => ['required'],
            'long_name' => ['required'],
            'street_address' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'state' => '',
            'zip' => ['required'],
            'email' => ['required,email'],
            'phone_number' => ['required', new PhoneNumber()],
            'mobile_number' => '',
            'extension' => '',
            'school_code' => ['required', new MinThreeWord()],
        ];
    }
}
