<?php

namespace App\Http\Controllers\Parent\Api;

use App\Events\TransactionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\StripePaymentRequest;
use App\Models\Lunch;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\Transaction;
use DateInterval;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PHPUnit\Runner\Exception;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripePaymentController extends Controller
{
    public function checkout(StripePaymentRequest $request): JsonResponse
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

        $lunch = Lunch::where('id', $validate['lunch_id'])->first();

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

        // STRIPE

        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        // $stripeCustomer = Customer::create([
        //     'address' =>
        // ])

        $checkout_session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $validate['title'],
                    ],
                    'unit_amount' => $validate['price'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('parent.checkout_success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('parent.checkout_cancel', [], true).'?session_id={CHECKOUT_SESSION_ID}',
        ]);

        // Payment
        $transaction = Transaction::create([
            'user_id' => $student->user_id,
            'student_id' => $student->id,
            'merchant_id' => $lunch->merchant_id,
            'transaction_date' => now()->format('Y-m-d'),
            'billingo_transaction_id' => null,
            'amount' => 1,
            'transaction_type' => 'debit',
            'billing_type' => 'invoice',
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
            'payment_status' => 'outstanding',
            'stripe_payment' => true,
            'stripe_pending' => true,
            'stripe_session_id' => $checkout_session->id,

        ]);

        $lunch = PeriodicLunch::create([
            'student_id' => $student->id,
            'transaction_id' => $transaction->id,
            'merchant_id' => $lunch->merchant_id,
            'lunch_id' => $validate['lunch_id'],
            'card_data' => 'hardcoded instead of $student->card_data',
            'start_date' => $claimDates[0],
            'end_date' => $claimDates[count($claimDates) - 1],
            'claims' => json_encode($claimsJson),
            'payment' => 'outstanding',
        ]);
        if ($transaction->billing_type !== 'none') {
            event(new TransactionCreated($transaction));
        }

        return response()->json($checkout_session);
    }

    public function success(Request $request): View
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {
            $session_id = $request->get('session_id');
            $session = Session::retrieve($session_id);

            if (! $session) {
                return view('parent.cancel');
            }

            $payment = Transaction::query()->where('stripe_session_id', $session_id)->whereIn('payment_status', ['outstanding', 'paid'])->first();

            if (! $payment) {
                throw new NotFoundHttpException();
            }

            if ($payment->payment_status == 'outstanding') {
                $this->updateOrderAndSession($payment);
            }

            $customer = auth()->user();
            // dump($customer);

            return view('parent.success', compact('customer'));
        } catch(NotFoundHttpException $exception) {
            throw $exception;
        } catch(Exception $exception) {
            return view('parent.cancel');
        }
    }

    public function cancel(Request $request)
    {
        dd($request->all);
    }

    public function webhook()
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $endpoint_secret = 'whsec_dba703edd0b062ce10cd089ef984e5b240e310e1dcb35bb50e962ebb83345c44';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(401);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(402);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];

                $payment = Transaction::query()->where('stripe_session_id', $sessionId)->where('payment_status', 'outstanding')->first();

                if ($payment) {
                    $this->updateOrderAndSession($payment);
                }

                // ... handle other event types
            default:
                echo 'Received unknown event type '.$event->type;
        }

        http_response_code(200);

        return response('', 200);
    }

    private function updateOrderAndSession(Transaction $transaction)
    {
        $transaction->stripe_pending = false;
        $transaction->payment_status = 'paid';
        $transaction->update();

        $order = PeriodicLunch::where('transaction_id', $transaction->id)->first();
        $order->payment = 'paid';
        $order->update();
    }
}
