<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;

class ResetPasswordController extends Controller
{
	public function resetPasswordForm(Request $request, $token = null): View|RedirectResponse
	{
		if ($this->checkIfTokenExists($request))
		{
			return view('auth.reset-password')->with(['token' => $token, 'email' => $request->email]);
		}

		return view('auth.redirect-template')
		->with(['header' => 'Invalid token', 'title' => 'Invalid token', 'description' => 'Your request is either missing, using an invalid or expired token.', 'small_description' => ' Try requesting a new password reset.']);
	}

	public function passwordUpdate(ResetPasswordRequest $request): RedirectResponse
	{
		DB::transaction(function () use ($request) {
			if ($this->checkIfTokenExists($request))
			{
				User::where('email', $request->email)->update([
					'password' => bcrypt($request->password),
				]);

				DB::table('password_resets')
					->where([
						'email' => $request->email,
						'token' => $request->token, ])
					->delete();
			}
		});

		return redirect()->route('dashboard')->with('updated', 'Password updated');
	}

	protected function checkIfTokenExists($request)
	{
		return DB::table('password_resets')
		->where([
			'email' => $request->email,
			'token' => $request->token, ])
		->first();
	}
}
