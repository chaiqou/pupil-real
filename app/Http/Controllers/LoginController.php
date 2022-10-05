<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function redirIfLoggedIn(Request $request){
        if(Auth::check()){
            return redirect('/dash');
        }
        return view('signin');
    }

    public function authenticate(Request $request)
    {
        Log::info('Attempting to authenticate user');
        Log::info($request->all());
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember-me');
        if(Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            // Authentication passed...
            Log::info('Authentication successful');
            $request->session()->regenerate();
            return redirect()->intended('dash');
        }
        Log::info('Authentication failed at' . date('Y-m-d H:i:s'));
        //Pass the error message to the view

        return back()->withErrors(['email' => 'These credentials do not match our records.',]);
    }
}
