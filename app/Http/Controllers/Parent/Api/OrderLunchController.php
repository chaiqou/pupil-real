<?php

namespace App\Http\Controllers\Parent\Api;

use App\Helpers\CalculateClaims;
use App\Http\Controllers\BillingoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\LunchOrderRequest;
use App\Models\Lunch;
use App\Models\LunchMenu;
use App\Models\PendingTransaction;
use App\Models\PeriodicLunch;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderLunchController extends Controller
{
    public function availableOrders(Request $request): JsonResponse
    {
        $student_id = $request->route('student_id');
        $orders = PeriodicLunch::where('student_id', $student_id)->get();

        return response()->json(['orders' => $orders]);
    }

    public function orderLunch(LunchOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $student = Student::where('id', $validated['student_id'])->first();
        $pricePeriod = Lunch::where('id', $validated['lunch_id'])->first()->price_period;
        $lunch = Lunch::where('id', $validated['lunch_id'])->first();

        $calculateClaims = new CalculateClaims(['claims' => $validated['claim_days'], 'claimables' => $validated['claimables']]);
        $claimResult = $calculateClaims->calculateClaimsJson();

        DB::transaction(function () use ($student, $validated, $claimResult, $pricePeriod, $lunch) {
            $pending_transaction = PendingTransaction::create([
                'user_id' => $student->user_id,
                'student_id' => $student->id,
                'merchant_id' => $lunch->merchant_id,
                'transaction_identifier' => 'here_should_be_some_hash',
                'transaction_date' => now()->format('Y-m-d'),
                'transaction_amount' => 1,
                'transaction_type' => 'payment',
                'comments' => json_encode([
                    'comment' => 'Placed lunch order on '.now()->format('Y-m-d'),
                    'comment_history' => [],
                ]),
                'history' => json_encode([
                    'history' => [],
                ]),
                'payment_method' => 'bank_transfer',
                'billing_type' => 'proforma',
                'billing_items' => json_encode([
                    'name' => 'Test lunch '.$claimResult['claimDates'][0].' - '.$claimResult['claimDates'][count($claimResult['claimDates']) - 1],
                    'unit_price' => $pricePeriod,
                    'unit_price_type' => 'gross',
                    'quantity' => 1,
                    'unit' => 'db',
                    'vat' => '27%',
                ]),
                'convert_to_invoice' => true,
                'billing_provider' => 'billingo',
                'billing_comment' => json_encode([
                    'comment' => 'hardcoded billing comment',
                ]),
            ]);

            $lunch = PeriodicLunch::create([
                'student_id' => $student->id,
                'pending_transaction_id' => $pending_transaction->id,
                'merchant_id' => $lunch->merchant_id,
                'lunch_id' => $validated['lunch_id'],
                'card_data' => 'hardcoded instead of $student->card_data',
                'start_date' => reset($claimResult['claimDates']),
                'end_date' => end($claimResult['claimDates']),
                'claims' => json_encode($claimResult['claimJson']),
            ]);

            foreach ($validated['claim_days'] as $date) {
                $day = Carbon::parse($date)->addDay()->format('Y-m-d');
                $lunch_menu = LunchMenu::where('date', $day)->first();
                $periodic_lunch = PeriodicLunch::where('claims', 'like', "%$day%")->first();

                if ($lunch_menu && $periodic_lunch) {
                    $claims_array = json_decode($periodic_lunch->claims, true);
                    $menus_array = json_decode($lunch_menu['menus'], true);

                    // Loop through each date in the $claims_array and check if it matches the "day" value in $validated
                    foreach ($claims_array as $date => $claims) {
                        if ($date === $day) {
                            // Loop through each claim for that date and check if the "name" value matches the "menu_type" value in $this->validated.
                            foreach ($claims as $index => $claim) {
                                foreach ($menus_array as $menu_key => $menu) {
                                    foreach ($menu as $menu_name) {
                                        if ($claim['name'] === $menu_name['name']) {
                                            $claims_array[$date][$index]['menu'] = $menu_name['menus'];
                                            $claims_array[$date][$index]['menu_code'] = 0;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $periodic_lunch->claims = json_encode($claims_array);
                    $periodic_lunch->save();
                }
            }

            BillingoController::providePendingTransactionToBillingo($pending_transaction);

            if (! $pending_transaction || ! $lunch) {
                DB::rollBack();
            }
        });

        return response()->json(['success' => 'success']);
    }
}
