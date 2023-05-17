<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emails.*' => ['required', 'email'],
        ];
    }
}
