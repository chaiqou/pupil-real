<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\PeriodicLunch;
use Illuminate\Http\JsonResponse;

class PieChartController extends Controller
{
    public function calculateChartInfo(): JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $lunches = Lunch::where('merchant_id', $merchant->id)->get();
        foreach ($lunches as $lunch) {
            $count = PeriodicLunch::where('lunch_id', $lunch->id)->count();
            if ($count > 0) {
                $lunchData[] = [
                    'id' => $lunch->id,
                    'title' => $lunch->title,
                    'share_count' => $count,
                ];
            }
        }

        return response()->json($lunchData);
    }
}
