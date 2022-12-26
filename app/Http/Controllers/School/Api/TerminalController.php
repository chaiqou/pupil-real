<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\StoreTerminalRequest;
use App\Http\Resources\TerminalResource;
use App\Models\Merchant;
use App\Models\Terminal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class TerminalController extends Controller
{
    public function store(StoreTerminalRequest $request): array
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $public_key = $request->user()->createToken($request->public_key);
        $private_key = $request->user()->createToken($request->private_key);

        $publicKeyToUpper = strtoupper($public_key->plainTextToken);
        $privateKeyToUpper = strtoupper($private_key->plainTextToken);
        $terminal = Terminal::create([
            'name' => $request->name,
            'serial_number' => $request->serial_number,
            'note' => $request->note,
            'merchant_id' => $merchant->id,
            'user_id' => auth()->user()->id,
            'public_key' => str_replace('|', '-', $publicKeyToUpper),
            'private_key' => str_replace('|', '-', $privateKeyToUpper),
        ]);

        $keys = ['PUBLIC-KEY' => $terminal->public_key, 'PRIVATE-KEY' => $terminal->private_key];
        $terminals = Terminal::where('merchant_id', $merchant->id)->latest()->paginate(5);

        return [
            $keys,
            $terminals,
        ];
    }

    public function get(Request $request): ResourceCollection
    {
        $terminals = Terminal::where('merchant_id', $request->merchant_id)->latest()->paginate(5);

        return TerminalResource::collection($terminals);
    }

    public function getSignature(Request $request): JsonResponse
    {
        $terminal = Terminal::where('public_key', $request->public_key)->first();
        if($terminal){
            $terminal->update(['verification' => Str::random('24')]);
            return response()->json(['verification' => $terminal->verification], 200);
        }else{
            return response()->json(['error' => 'Cannot find resource'], 404);
        }
    }

    public function verifySignature(Request $request): JsonResponse
    {
        $terminal = Terminal::where('public_key', $request->public_key)->first();
        if ($terminal) {
            $realSignature = strtoupper(hash('sha512', $terminal->verification.$terminal->private_key));
            $givenSignature = strtoupper($request->signature);

            if ($realSignature === $givenSignature) {
                return response()->json(['message' => 'Signature verified successfully'], 200);
            } else {
                return response()->json(['error' => 'Cannot find resource'], 404);
            }
        } else {
        return response()->json(['error' => 'Cannot find resource'], 404);
    }
    }
}
