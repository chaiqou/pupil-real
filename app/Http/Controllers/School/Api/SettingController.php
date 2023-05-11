<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Models\BillingoData;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingController extends Controller
{
    public static function updateBillingoApiKey(Request $request): JsonResponse
    {
        $user = User::where('id', auth()->user()->id)->first();
        $merchant = Merchant::where('user_id', $user->id)->first();
        $billingoData = BillingoData::where('merchant_id', $merchant->id)->first();
        $response = Http::withHeaders([
            'X-API-KEY' => $request->billingo_api_key,
        ])->get('https://api.billingo.hu/v3/utils/time');

        if ($response->status() === 401) {
            // API key is unauthorized, probably revoked or incorrect
            return response()->json(['message' => 'Your api key is incorrect, please check again'], 404);
        } else {
            $billingoData->update([
                'billingo_api_key' => $request->billingo_api_key,
                'billingo_suspended' => false,
            ]);

            return response()->json('Billingo api key accepted and updated successfully');
        }
    }
}
