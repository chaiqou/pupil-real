<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invite\InviteRequest;
use App\Http\Requests\Invite\PersonalFormRequest;
use App\Http\Requests\Invite\SetupAccountRequest;
use App\Mail\InviteUser;
use App\Models\Invite;
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
			'state'     => 0,
			'school_id' => 32,
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
		return redirect()->back();
	}

	public function personalForm(): View
	{
		return view('invite.personal-form', [
			'uniqueID' => request()->uniqueID,
		]);
	}

	public function submitPersonalForm(PersonalFormRequest $request): RedirectResponse
	{
		return redirect()->back();
	}
}
