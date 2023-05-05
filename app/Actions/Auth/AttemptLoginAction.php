<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class AttemptLoginAction
{
    public function execute(array $credentials, bool $remember = false)
    {
        return Auth::attempt($credentials, $remember);
    }
}
