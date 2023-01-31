<?php

namespace App\Http\Controllers\Parent\Api;

use App\Events\TransactionCreated;
use App\Helpers\CalculateClaims;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Models\Lunch;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderLunchController extends Controller
{
    public function availableOrders(): JsonResponse
    {
        $orders = PeriodicLunch::whereDate('end_date', '>=', Carbon::now())->get();

        return response()->json(['orders' => $orders]);
    }

    public function orderLunch(LunchOrderRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $student = Student::where('id', $validate['student_id'])->first();
        $pricePeriod = Lunch::where('id', $validate['lunch_id'])->first()->price_period;
        $lunch = Lunch::where('id', $validate['lunch_id'])->first();

        $calculateClaims = new CalculateClaims(['claims' => $validate['claims'], 'claimables' => $validate['claimables']]);
        $claimResult = $calculateClaims->calculateClaimsJson();

        DB::transaction(function () use ($student, $validate, $claimResult, $pricePeriod, $lunch) {
            $transaction = Transaction::create([
                'user_id' => $student->user_id,
                'student_id' => $student->id,
                'merchant_id' => $lunch->merchant_id,
                'transaction_date' => now()->format('Y-m-d'),
                'billingo_transaction_id' => null,
                'amount' => 1,
                'transaction_type' => 'debit',
                'billing_type' => 'proforma',
                'billing_comment' => 'billing_comment_here',
                'billing_items' => json_encode([
                    'name' => 'Test lunch '.$claimResult['claimDates'][0].' - '.$claimResult['claimDates'][count($claimResult['claimDates']) - 1],
                    'unit_price' => $pricePeriod,
                    'unit_price_type' => 'gross',
                    'quantity' => 1,
                    'unit' => 'db',
                    'vat' => '27%',
                ]),
                'pending' => json_encode([
                    'pending' => 0,
                    'pending_history' => [],
                ]),
                'comment' => json_encode([
                    'comment' => 'Placed lunch order on '.now()->format('Y-m-d'),
                    'comment_history' => [],
                ]),
            ]);

            $lunch = PeriodicLunch::create([
                'student_id' => $student->id,
                'transaction_id' => $transaction->id,
                'merchant_id' => $lunch->merchant_id,
                'lunch_id' => $validate['lunch_id'],
                'card_data' => 'hardcoded instead of $student->card_data',
                'start_date' => $claimResult['claimDates'][0],
                'end_date' => $claimResult['claimDates'][count($claimResult['claimDates']) - 1],
                'claims' => json_encode($claimResult['claimJson']),
            ]);
            if ($transaction->billing_type !== 'none') {
                event(new TransactionCreated($transaction));
            }
        });

        return response()->json(['success' => 'success']);
    }
}
