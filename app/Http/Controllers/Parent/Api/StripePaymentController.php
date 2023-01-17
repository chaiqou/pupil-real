<?php

namespace App\Http\Controllers\Parent\Api;

use Stripe\StripeClient;
use Illuminate\Http\Request;
use PHPUnit\Runner\Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\StripePaymentRequest;

class StripePaymentController extends Controller
{
    public function checkout(StripePaymentRequest $request): JsonResponse
    {
        $validate = $request->validated();
        try {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [[
                  'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' =>  $validate['title'],
                    ],
                    'unit_amount' => $validate['price'] * 100,
                  ],
                  'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://127.0.0.1:8000/success',
                'cancel_url' => 'http://127.0.0.1:8000/cancel',
              ]);

            return response()->json($checkout_session, 200);
        } catch(Exception $ex) {
            return response()->json(['error' => $ex], 500);
        }
    }
}
