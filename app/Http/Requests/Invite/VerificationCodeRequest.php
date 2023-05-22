<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'verification_code.*' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'verification_code.*.required' => 'Please fill all fields',
        ];
    }
}
