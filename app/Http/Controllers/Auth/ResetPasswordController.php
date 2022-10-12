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

		// here should be error page - work for morning
		return redirect()->route('dashboard');
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
