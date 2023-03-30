<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json('Password successfully updated');
    }
}
