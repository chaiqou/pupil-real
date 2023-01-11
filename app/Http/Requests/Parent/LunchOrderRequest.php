<?php

namespace App\Http\Requests\Parent;

use Illuminate\Foundation\Http\FormRequest;

class LunchOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'student_id' => 'required',
            'available_days' => 'required|array',
            'claimables' => 'required|array',
            'period_length' => 'required',
            'lunch_id' => 'required',
            'claims' => 'required|array|unique:periodic_lunches,claims',
        ];
    }
}
