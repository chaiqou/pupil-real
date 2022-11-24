<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LunchRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'active_range' => 'required',
            'period_length' => 'required',
            'extras' => 'array',
            'holds' => 'array',
            'price_day' => 'required',
            'price_period' => 'required',
            'tags' => 'required',
            'claimables' => 'required',
        ];
    }
}
