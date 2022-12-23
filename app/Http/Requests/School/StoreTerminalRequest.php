<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class StoreTerminalRequest extends FormRequest
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
            'name' => 'required',
            'serial_number' => 'required|min:12|max:12',
            'note' => '',
            'public_key' => 'required|string',
            'private_key' => 'required|string',
        ];
    }
}