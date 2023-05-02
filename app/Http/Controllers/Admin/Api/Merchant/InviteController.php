<?php

namespace App\Http\Controllers\Admin\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InviteMerchantRequest;
use App\Http\Resources\Admin\MerchantInviteResource;
use App\Mail\InviteMerchantMail;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function get(): ResourceCollection
    {
        $invites = Invite::with('school')->where('role', 'merchant')->where('school_id', request()->school_id)->latest()->paginate(5);

        return MerchantInviteResource::collection($invites);
    }

    public function store(InviteMerchantRequest $request): ResourceCollection|JsonResponse
    {
        $existsInInvites = Invite::where('email', $request->email)->first();
        $existsInUsers = User::where('email', $request->email)->first();
        if (isset($existsInInvites)) {
            return response()->json(['message' => 'Invite for this email exists'], 404);
        }
        if (isset($existsInUsers)) {
            return response()->json(['message' => 'User with this email exists'], 404);
        }

        $invite = Invite::create([
            'uniqueID' => Str::random(32),
            'email' => $request->email,
            'school_id' => request('schoolId'),
            'role' => 'merchant',
        ]);
        $language = config('app.locale');
        Mail::to($invite->email)->send(new InviteMerchantMail($invite, $language));
        $invite->update(['state' => 1]);
        $invites = Invite::with('school')->where('role', 'merchant')->latest('created_at')->paginate(5);

        return MerchantInviteResource::collection($invites);
    }
}
