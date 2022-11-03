<?php

namespace App\Http\Requests\Parent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'student_id'     => 'required',
            'last_name'      => 'required',
            'first_name'     => 'required',
            'country'        => 'required',
            'street_address' => 'required',
            'city'           => 'required',
            'state'          => 'required',
            'zip'            => 'required',
        ];
    }
}