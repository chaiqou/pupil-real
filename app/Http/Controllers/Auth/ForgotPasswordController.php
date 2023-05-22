<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use App\Traits\BrowserNameAndDevice;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    use BrowserNameAndDevice;

    public function forgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendForgotPasswordMail(ForgotPasswordRequest $request): RedirectResponse
    {
        $token = Str::random(64);

        $user = User::where('email', $request->email)->first();

        $user->update(['token' => $token]);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $name = $user->first_name;
        $language = $user->language;
        Mail::to($request->email)->send(new ForgotPasswordMail($token, $name, $this->getBrowserName(), $this->getDeviceName(), $language));

        return redirect()->route('forgot.redirect');
    }

    public function forgotRedirect(): View
    {
        return view('auth.redirect-template')
            ->with(['header' => 'Email sent', 'title' => 'Check your email', 'description' => 'Check your email address for instructions on how to reset your password', 'small_description' => "If you can't find the email in a few minutes, check your spam folder."]);
    }
}
