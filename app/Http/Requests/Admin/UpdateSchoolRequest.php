<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'short_name' => 'required',
            'full_name' => 'required',
            'long_name' => 'required',
            'street_address' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'school_code' => 'required|string|min:3'
        ];
    }
}
