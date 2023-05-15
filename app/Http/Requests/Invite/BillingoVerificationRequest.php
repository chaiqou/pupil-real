<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class BillingoVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'api_key' => ['required'],
        ];
    }
}
