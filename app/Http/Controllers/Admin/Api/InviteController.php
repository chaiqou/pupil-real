<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\InviteRequest;
use App\Http\Resources\InviteResource;
use App\Mail\InviteUserMail;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function get(): ResourceCollection
    {
        $invites = Invite::with('school')->where('role', 'parent')->latest('created_at')->paginate(5);

        return InviteResource::collection($invites);
    }

    public function getInviteEmails(): JsonResponse
    {
        $invites = Invite::all();
        $emails = [];

        foreach ($invites as $invite) {
            array_push($emails, $invite->email);
        }

        return response()->json($emails);
    }

    public function getUserEmails(): JsonResponse
    {
        $users = User::all();
        $emails = [];

        foreach ($users as $user) {
            array_push($emails, $user->email);
        }

        return response()->json($emails);
    }

    public function store(InviteRequest $request): JsonResponse|ResourceCollection
    {
        $emails = $request->emails;
        foreach ($emails as $email) {
            $invite = Invite::create([
                'uniqueID' => Str::random(32),
                'email' => $email,
                'school_id' => request('schoolId'),
                'role' => 'parent',
            ]);
            Mail::to($email)->send(new InviteUserMail($invite));
            $invite->update(['state' => 1]);
        }
        $invites = Invite::with('school')->where('role', 'parent')->latest('created_at')->paginate(5);

        return InviteResource::collection($invites);
    }

    public function delete(Request $request): ResourceCollection
    {
        $invite = Invite::where('id', $request->invite_id)->first();
        $invite->delete();
        $invites = Invite::with('school')->where('role', 'parent')->latest('created_at')->paginate(5);

        return InviteResource::collection($invites);
    }
}
