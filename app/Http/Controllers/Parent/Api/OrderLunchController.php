<?php

namespace App\Http\Controllers\Parent\Api;

use App\Events\TransactionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Models\Lunch;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderLunchController extends Controller
{
    public function availableOrders(): JsonResponse
    {
        sleep(1);
        $orders = PeriodicLunch::whereDate('end_date', '>=', Carbon::now())->get();

        return response()->json(['orders' => $orders]);
    }

    public function index(LunchOrderRequest $request): JsonResponse
    {
        $validate = $request->validated();

        // Get correct claims days and add each of them 1 day
        $claimDates = [];
        foreach ($validate['claims'] as $date) {
            $date = new DateTime($date);
            $date->add(new DateInterval('P1D'));
            $claimDates[] = $date->format('Y-m-d H:i:s');
        }

        $student = Student::where('id', $validate['student_id'])->first();
        $pricePeriod = Lunch::where('id', $validate['lunch_id'])->first()->price_period;

        // Generates claims json for each days and also loops over claimables

        $claimsJson = [];

        foreach ($claimDates as $date) {
            $claimables = [];

            foreach ($validate['claimables'] as $claimable) {
                $claimables[] = [
                    'name' => $claimable,
                    'claimed' => false,
                    'claimed_date' => null,
                ];
            }

            $claimsJson[$date] = $claimables;
        }

        DB::transaction(function () use ($student, $validate, $claimDates, $claimsJson, $pricePeriod) {
            $transaction = Transaction::create([
                'user_id' => $student->user_id,
                'student_id' => $student->id,
                'merchant_id' => $student->school_id,
                'transaction_date' => now()->format('Y-m-d'),
                'billingo_transaction_id' => null,
                'amount' => 1,
                'transaction_type' => 'debit',
                'billing_type' => 'proforma',
                'billing_comment' => 'billing_comment_here',
                'billing_item' => json_encode([
                    'name' => 'Test lunch '.$claimDates[0].' - '.$claimDates[count($claimDates) - 1],
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
                'merchant_id' => $student->school_id,
                'lunch_id' => $validate['lunch_id'],
                'card_data' => 'hardcoded instead of $student->card_data',
                'start_date' => $claimDates[0],
                'end_date' => $claimDates[count($claimDates) - 1],
                'claims' => json_encode($claimsJson),
            ]);
            if ($transaction->billing_type !== 'none') {
                event(new TransactionCreated($transaction));
            }
        });

        return response()->json(['success' => 'success']);
    }
}
