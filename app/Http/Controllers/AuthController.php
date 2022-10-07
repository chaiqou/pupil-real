<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        Log::info('Attempting to authenticate user');
        Log::info($request->all());
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember-me');
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            // Authentication passed...
            Log::info('Authentication successful');
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        Log::info('Authentication failed at' . date('Y-m-d H:i:s'));
        //Pass the error message to the view

        return back()->withErrors(['email' => 'These credentials do not match our records.',]);
    }


    public function redirectIfLoggedIn(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        }
        return view('signin');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        return redirect(route('default'));
    }
}
