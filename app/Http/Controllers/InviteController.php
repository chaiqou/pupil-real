<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteRequest;
use App\Mail\InviteUser;
use App\Models\Invite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
	public function sendInvite(InviteRequest $request)
	{
		$invite = Invite::create([
			'uniqueID'  => Str::random(32),
			'email'     => $request->email,
			'state'     => 0,
			'school_id' => 32,
		]);
		Mail::to($invite->email)->send(new InviteUser($invite->email));
		$invite->update(['state' => 1]);

		return redirect()->back();
	}
}
