<?php

namespace App\Http\Requests\Parent;

use Illuminate\Foundation\Http\FormRequest;

class LunchOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required',
            'claimables' => 'required|array',
            'lunch_id' => 'required',
            'claim_days' => 'required|array|unique:periodic_lunches,claims',
            'price' => 'required|integer',
        ];
    }
}
