<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use PHPUnit\Runner\Exception;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function checkout(Request $request): JsonResponse
    {
        try {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [[
                  'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' =>  $request['claimables'][0],
                    ],
                    'unit_amount' => $request['price'] * 100,
                  ],
                  'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost:4242/success',
                'cancel_url' => 'http://localhost:4242/cancel',
              ]);

            return response()->json($checkout_session, 200);
        } catch(Exception $ex) {
            return response()->json(['error' => $ex]);
        }
    }
}
