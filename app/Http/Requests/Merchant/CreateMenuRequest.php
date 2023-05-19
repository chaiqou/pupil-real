<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'day' => 'required|date',
            'menu_type' => 'required|string|max:255|min:3',
            'menus' => 'required',
            'lunch_id' => 'required|numeric',

        ];
    }
}
