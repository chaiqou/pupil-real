<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class PersonalFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'last_name' => ['required'],
            'first_name' => ['required'],
            'country' => ['required'],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => 'Last name is required.',
            'first_name.required' => 'First name is required.',
        ];
    }
}
