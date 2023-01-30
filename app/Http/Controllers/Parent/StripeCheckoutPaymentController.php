<?php

namespace App\Http\Controllers\Parent;

use App\Events\TransactionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\StripePaymentRequest;
use App\Models\Lunch;
use App\Models\PendingTransaction;
use App\Models\PeriodicLunch;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PHPUnit\Runner\Exception;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UnexpectedValueException;

class StripeCheckoutPaymentController extends Controller
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

        $customer = auth()->user();

        $existingCustomer = User::where('id', $customer->id)->where('stripe_customer_id', '!=', null)->first();

        if ($existingCustomer != null) {
            $formattedStartDate = new DateTime($claimDates[0]);
            $formattedEndDate = new DateTime($claimDates[count($claimDates) - 1]);
            $formattedStartDate = $formattedStartDate->format('Y-m-d');
            $formattedEndDate = $formattedEndDate->format('Y-m-d');
            $checkout_session = Session::create([
                'customer' => $existingCustomer->stripe_customer_id,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'huf',
                        'product_data' => [
                            'name' => $validate['title'].' | '.$formattedStartDate.' - '.$formattedEndDate,
                        ],
                        'unit_amount' => $validate['price'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('parent.checkout_success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('parent.checkout_cancel', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            ]);
        } else {
            $customerAdressDetails = json_decode($customer->user_information);

            $stripeCustomer = Customer::create([
                'address' => [
                    'line1' => $customerAdressDetails->street_address,
                    'state' => $customerAdressDetails->state,
                    'postal_code' => $customerAdressDetails->zip,
                    'country' => $customerAdressDetails->country,
                    'city' => $customerAdressDetails->city,
                ],
                'email' => $customer->email,
                'name' => $customer->first_name,
            ]);

            $checkout_session = Session::create([
                'customer' => $stripeCustomer->id,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'huf',
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
        }

        $pending_transaction = PendingTransaction::create([
            'user_id' => $student->user_id,
            'student_id' => $student->id,
            'merchant_id' => $lunch->merchant_id,
            'transaction_identifier' => 'here_should_be_some_hash',
            'transaction_date' => now()->format('Y-m-d'),
            'transaction_amount' => 1,
            'transaction_type' => 'storno',
            'comments' => json_encode([
                'comment' => 'Placed lunch order on '.now()->format('Y-m-d'),
                'comment_history' => [],
            ]),
            'history' => json_encode([
                'history' => [],
            ]),
            'stripe_session_id' => $checkout_session->id,
            'payment_method' => 'stripe',
            'billing_type' => 'invoice',
            'billing_item' => json_encode([
                'name' => 'Test lunch '.$claimDates[0].' - '.$claimDates[count($claimDates) - 1],
                'unit_price' => $pricePeriod,
                'unit_price_type' => 'gross',
                'quantity' => 1,
                'unit' => 'db',
                'vat' => '27%',
            ]),
            'billing_provider' => 'none',
            'billing_comment' => json_encode([
                'comment' => 'hardcoded billing comment',
            ]),
        ]);

        $lunch = PeriodicLunch::create([
            'student_id' => $student->id,
            'pending_transactions_id' => $pending_transaction->id,
            'merchant_id' => $lunch->merchant_id,
            'lunch_id' => $validate['lunch_id'],
            'card_data' => 'hardcoded instead of $student->card_data',
            'start_date' => $claimDates[0],
            'end_date' => $claimDates[count($claimDates) - 1],
            'claims' => json_encode($claimsJson),
            'payment' => 'outstanding',
        ]);

        return response()->json($checkout_session);
    }

    public function success(Request $request): View
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {
            $session_id = $request->get('session_id');
            $session = Session::retrieve($session_id);

            $pending_transaction = PendingTransaction::query()->where('stripe_session_id', $session_id)->first();
            $order = PeriodicLunch::where('pending_transactions_id', $pending_transaction->id)->first();
            $customer = auth()->user();

            $transaction = Transaction::create([
                'user_id' => $pending_transaction->user_id,
                'student_id' => $pending_transaction->id,
                'merchant_id' => $pending_transaction->merchant_id,
                'transaction_identifier' => 'here_should_be_some_hash',
                'transaction_date' => now()->format('Y-m-d'),
                'transaction_amount' => 1,
                'transaction_type' => 'storno',
                'comments' => json_encode([
                    'comment' => 'Placed lunch order on '.now()->format('Y-m-d'),
                    'comment_history' => [],
                ]),
                'history' => json_encode([
                    'history' => [],
                ]),
                'stripe_payment_intent' => $session->payment_intent,
                'payment_method' => 'stripe',
                'billing_type' => 'invoice',
                'billing_item' => json_encode([
                    // 'name' => 'Test lunch '.$claimDates[0].' - '.$claimDates[count($claimDates) - 1],
                    // 'unit_price' => $pricePeriod,
                    'unit_price_type' => 'gross',
                    'quantity' => 1,
                    'unit' => 'db',
                    'vat' => '27%',
                ]),
                'billing_provider' => 'none',
                'billing_comment' => json_encode([
                    'comment' => 'hardcoded billing comment',
                ]),
            ]);

            if (! $transaction) {
                throw new NotFoundHttpException();
            }

            if ($transaction) {
                event(new TransactionCreated($transaction));
            }

            if (! $session) {
                return view('parent.cancel', compact('order'));
            }

            $order->lunch_title = Lunch::where('id', $order->lunch_id)->first()->title;

            return view('parent.success', compact('customer', 'order'));
        } catch(NotFoundHttpException $exception) {
            throw $exception;
        } catch(Exception $exception) {
            return view('parent.cancel', compact('order'));
        }
    }

    public function cancel(Request $request)
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');
        $session = Session::retrieve($session_id);

        $transaction = Transaction::where('stripe_session_id', $session_id)->first();
        $order = PeriodicLunch::where('transaction_id', $transaction->id)->first();

        if (! $order) {
            return redirect('/');
        }
        $order->lunch_title = Lunch::where('id', $order->lunch_id)->first()->title;

        if ($transaction && $session->status === 'open') {
            $stripe = new StripeClient(getenv('STRIPE_SECRET_KEY'));

            $stripe->checkout->sessions->expire(
                $session_id,
                []
            );

            $this->deleteLunchIfCancelled($transaction);

            return view('parent.cancel', compact('order'));
        } elseif ($transaction) {
            $this->deleteLunchIfCancelled($transaction);

            return view('parent.cancel', compact('order'));
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function webhook()
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $endpoint_secret = 'whsec_dba703edd0b062ce10cd089ef984e5b240e310e1dcb35bb50e962ebb83345c44';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(UnexpectedValueException $e) {
            http_response_code(401);
            exit();
        } catch(SignatureVerificationException $e) {
            http_response_code(402);
            exit();
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];

                $payment = Transaction::query()->where('stripe_session_id', $sessionId)->where('payment_status', 'outstanding')->first();

                if ($payment) {
                    $this->updateOrderAndSession($payment);
                }

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

    private function deleteLunchIfCancelled(Transaction $transaction)
    {
        $transaction->update(['cancelled' => true]);
        PeriodicLunch::where('transaction_id', $transaction->id)->delete();
    }
}
