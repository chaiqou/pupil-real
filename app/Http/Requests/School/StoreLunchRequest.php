<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class StoreLunchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'active_range' => 'required',
            'period_length' => 'required',
            'extras' => 'array',
            'holds' => 'array',
            'price_period' => 'required|numeric|between:175,1000',
            'weekdays' => 'required',
            'claimables' => 'required',
            'available_days' => 'array',
            'buffer_time' => ['required', 'integer', 'min:1', 'max:72'],
            'vat' => 'required',
        ];
    }
}
