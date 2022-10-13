<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class PersonalFormRequest extends FormRequest
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
			'last_name'      => 'required',
			'first_name'     => 'required',
			'middle_name'    => 'required',
			'country'        => 'required',
			'street_address' => 'required',
			'city'           => 'required',
			'state'          => 'required',
			'zip'            => 'required',
		];
	}

	public function messages()
	{
		return [
			'last_name.required'   => 'Last name is required.',
			'first_name.required'  => 'First name is required.',
			'middle_name.required' => 'Middle name is required.',
		];
	}
}
