<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinThreeWord implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regexMinThreeWord = '/^([a-z0-9]*[a-z]){3}[a-z0-9]*$/i';
        return (bool)preg_match($regexMinThreeWord, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return response()->json(['message' => 'Please enter at least 3 words']);
    }
}
