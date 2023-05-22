<?php

namespace App\Http\Requests\Parent;

use Illuminate\Foundation\Http\FormRequest;

class StripePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|integer',
            'student_id' => 'required|integer',
            'lunch_id' => 'required|integer',
            'claimables' => 'required|array',
            'claims' => 'required|array',
        ];
    }
}
