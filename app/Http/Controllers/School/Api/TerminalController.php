<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TerminalResource;
use App\Models\Merchant;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TerminalController extends Controller
{
    public function store(Request $request)
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $public_key = $request->user()->createToken($request->public_key);
        $private_key = $request->user()->createToken($request->private_key);
        Terminal::create([
            'name' => '123',
            'serial_number' => '123123',
            'note' => 'Some note',
            'merchant_id' => $merchant->id,
            'user_id' => auth()->user()->id,
            'public_key' => $public_key->plainTextToken,
            'private_key' => $private_key->plainTextToken,
        ]);
        return ['token' => $public_key->plainTextToken];
    }

    public function get(Request $request): ResourceCollection
    {
        $terminals = Terminal::where('merchant_id', $request->merchant_id)->latest()->paginate(5);
        return TerminalResource::collection($terminals);
    }
}
