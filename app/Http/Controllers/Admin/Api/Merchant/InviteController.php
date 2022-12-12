<?php

namespace App\Http\Controllers\Admin\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InviteMerchantRequest;
use App\Http\Resources\Admin\MerchantInviteResource;
use App\Mail\InviteMerchant;
use App\Models\MerchantInvite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function get(): ResourceCollection
    {
        $invites = MerchantInvite::with('school')->latest()->paginate(5);

        return MerchantInviteResource::collection($invites);
    }

    public function store(InviteMerchantRequest $request): ResourceCollection|JsonResponse
    {
        $existsInInvites = MerchantInvite::where('email', $request->email)->first();
        $existsInUsers = User::where('email', $request->email)->first();
        if (isset($existsInInvites)) {
            return response()->json(['message'=>'Invite for this email exists'], 404);
        }
        if (isset($existsInUsers)) {
            return response()->json(['message'=>'User with this email exists'], 404);
        }

        $invite = MerchantInvite::create([
            'uniqueID' => Str::random(32),
            'email' => $request->email,
            'school_id' => request('schoolId'),
        ]);
        Mail::to($invite->email)->send(new InviteMerchant($invite));
        $invite->update(['state' => 1]);
        $invites = MerchantInvite::with('school')->latest()->paginate(5);
        return MerchantInviteResource::collection($invites);
    }
}
