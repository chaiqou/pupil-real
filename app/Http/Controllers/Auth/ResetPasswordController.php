<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
	public function resetPasswordForm(Request $request, $token = null): View
	{
		return view('auth.reset-password')->with(['token' => $token, 'email' => $request->email]);
	}

	public function passwordUpdate(ResetPasswordRequest $request): RedirectResponse
	{
		User::where('email', $request->email)->update([
			'password' => bcrypt($request->password),
		]);

		DB::table('password_resets')
			->where(['email' => $request->email])
			->delete();

		return redirect()->route('dashboard');
	}
}
