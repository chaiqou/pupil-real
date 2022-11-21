<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\InviteRequest;
use App\Http\Resources\School\InviteResource;
use App\Mail\InviteUser;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $invites = Invite::latest('created_at')->paginate(5);
        return InviteResource::collection($invites);
    }

    public function getInviteEmails(): JsonResponse
    {
        $invites = Invite::all();
        $emails = [];

        foreach($invites as $invite)
        {
            array_push($emails, $invite->email);
        }
        return response()->json($emails);
    }
    public function getUserEmails(): JsonResponse
    {
        $users = User::all();
        $emails = [];

        foreach($users as $user)
        {
            array_push($emails, $user->email);
        }
        return response()->json($emails);
    }


    public function store(InviteRequest $request): RedirectResponse
    {
        $emails = $request->emails;
        foreach($emails as $email)
        {
            $invite = Invite::create([
                'uniqueID' => Str::random(32),
                'email' => $email,
                'school_id' => $request->school_id,
            ]);
            Mail::to($email)->send(new InviteUser($invite));
            $invite->update(['state' => 1]);
        }

        return redirect()->back();
    }
}
