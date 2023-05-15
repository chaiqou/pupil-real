<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class StoreTerminalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
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
