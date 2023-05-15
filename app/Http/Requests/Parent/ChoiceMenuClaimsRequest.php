<?php

namespace App\Http\Requests\Parent;

use Illuminate\Foundation\Http\FormRequest;

class ChoiceMenuClaimsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|integer',
            'date' => 'required|date',
            'claimable' => 'required',
            'claimable_type' => 'required|string',
        ];
    }
}
