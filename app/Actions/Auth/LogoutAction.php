<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutAction
{
    public static function execute(Request $request)
    {
        auth()->user()->update(['two_factor_code' => null]);
        session()->forget('need_to_pass_2fa');
        session()->forget('email');
        session()->forget('password');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
