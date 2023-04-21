<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\InviteRequest;
use App\Http\Resources\InviteResource;
use App\Jobs\InviteUserJob;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function get(Request $request): ResourceCollection
    {
        $invites = Invite::where('school_id', $request->school_id)->where('role', 'parent')->latest('created_at')->paginate(5);

        return InviteResource::collection($invites);
    }

    public function getInviteEmails(Request $request): JsonResponse
    {
        $invites = Invite::all();
        $emails = [];

        foreach ($invites as $invite) {
            array_push($emails, $invite->email);
        }

        return response()->json($emails);
    }

    public function getUserEmails(Request $request): JsonResponse
    {
        $users = User::all();
        $emails = [];

        foreach ($users as $user) {
            array_push($emails, $user->email);
        }

        return response()->json($emails);
    }

    public function sendInvite(InviteRequest $request): JsonResponse
    {
        $emails = $request->emails;
        foreach ($emails as $email) {
            $invite = Invite::create([
                'uniqueID' => Str::random(32),
                'email' => $email,
                'school_id' => auth()->user()->school_id,
                'role' => 'parent',
            ]);
            InviteUserJob::dispatch($invite, $email)->onQueue('invite-users');
            $invite->update(['state' => 1]);
        }

        return response()->json('Invite(s) sent!');
    }

    public function delete(Request $request): ResourceCollection
    {
        $invite = Invite::where('id', $request->invite_id)->first();
        $invite->delete();
        $invites = Invite::where('school_id', auth()->user()->school_id)->where('role', 'parent')->latest('created_at')->paginate(5);

        return InviteResource::collection($invites);
    }
}
