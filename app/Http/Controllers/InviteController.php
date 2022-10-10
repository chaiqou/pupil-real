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
		$invite = new Invite();
		Mail::to($request->email)->send(new InviteUser($invite));
		$invite->update([
			'uniqueID' => Str::random(32),
			'email'    => $request->email,
			'state'    => 1,
		]);
	}
}
