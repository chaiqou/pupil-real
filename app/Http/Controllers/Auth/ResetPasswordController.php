<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function resetPasswordForm(Request $request, $token = null): View|RedirectResponse
    {
        if ($this->checkIfTokenExists($request)) {
            return view('auth.reset-password')->with(['token' => $token, 'email' => $request->email]);
        }

        return view('auth.redirect-template')
        ->with(['header' => 'Invalid token', 'title' => 'Invalid token', 'description' => 'Your request is either missing, using an invalid or expired token.', 'small_description' => ' Try requesting a new password reset.']);
    }

    public function passwordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'string',
                Password::min(8)
                ->mixedCase()
                ->numbers(),
            ],
        ]);
        DB::transaction(function () use ($request) {
            if ($this->checkIfTokenExists($request)) {
                $passwordResetUser = DB::table('password_resets')->where('token', $request->token)->first();
                User::where('email', $passwordResetUser->email)->update([
                    'password' => bcrypt($request->password),
                ]);

                DB::table('password_resets')
                    ->where(['token' => $request->token])
                    ->delete();
            }
        });

        return redirect()->route('default')->with(with(['success' => 'success', 'success_title' => 'Password updated', 'success_message' => 'You successfully updated your password.']));
    }

    protected function checkIfTokenExists($request)
    {
        return DB::table('password_resets')
        ->where(['token' => $request->token])
        ->first();
    }
}
