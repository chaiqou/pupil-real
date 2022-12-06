<?php

namespace App\Http\Requests\Admin;

use App\Rules\MinThreeWord;
use App\Rules\PhoneNumber;
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
            'short_name' => 'required',
            'full_name' => 'required',
            'long_name' => 'required',
            'street_address' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'email' => 'required|email',
            'phone_number' => ['required', new PhoneNumber()],
            'mobile_number' => '',
            'extension' => '',
            'school_code' => ['required', new MinThreeWord()]
        ];
    }
}
