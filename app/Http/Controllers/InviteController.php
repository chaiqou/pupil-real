<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invite\InviteRequest;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\SetupAccountRequest;
use App\Mail\InviteUser;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InviteController extends Controller
{
	public function sendInvite(InviteRequest $request): RedirectResponse
	{
		$invite = Invite::create([
			'uniqueID'  => Str::random(32),
			'email'     => $request->email,
		]);
		Mail::to($invite->email)->send(new InviteUser($invite));
		$invite->update(['state' => 1]);

		return redirect()->back();
	}

	public function setupAccount($uniqueID): View
	{
		$invite = Invite::where('uniqueID', $uniqueID)->first();
		$invite->update(['state' => 2]);
		return view('invite.setup-account', [
			'uniqueID' => $uniqueID,
		]);
	}

	public function submitSetupAccount(SetupAccountRequest $request): RedirectResponse
	{
		$user = User::create([
			'email'     => $request->email,
			'password'  => bcrypt($request->password),
		]);
		$invite = Invite::where('uniqueID', request()->uniqueID)->first();
		$invite->update([
			'email' => $user->email,
			'state' => 3,
		]);
		return redirect()->route('personal.form', ['uniqueID' => request()->uniqueID]);
	}

	public function personalForm(): View
	{
		return view('invite.personal-form', [
			'uniqueID' => request()->uniqueID,
		]);
	}

	public function submitPersonalForm(PersonalFormRequest $request): RedirectResponse
	{
		$user = User::where('uniqueID', request()->uniqueID)->first();
		$user->update([
			'last_name'   => $request->last_name,
			'first_name'  => $request->first_name,
			'middle_name' => $request->middle_name,
			'first_name'  => $request->first_name,
			'last_name'   => $request->last_name,
			'first_name'  => $request->first_name,
			'last_name'   => $request->last_name,
			'first_name'  => $request->first_name,
			'last_name'   => $request->last_name,
			'first_name'  => $request->first_name,
		]);
		return redirect()->back();
	}
}
