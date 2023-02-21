<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\PeriodicLunch;
use App\Models\School;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PieChartController extends Controller
{
    public function calculateChartInfo(Request $request)
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $lunches = Lunch::where('merchant_id', $merchant->id)->get();
        foreach($lunches as $lunch)
        {
            $count = PeriodicLunch::where('lunch_id', $lunch->id)->count();
            $lunchData[] = [
                'id' => $lunch->id,
                'title' => $lunch->title,
                'share_count' => $count,
            ];
        }
        return response()->json($lunchData);
    }
}
