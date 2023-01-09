<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionController extends Controller
{
    public function getTransactions(Request $request): ResourceCollection|JsonResponse
    {
        $transactions = Transaction::where('merchant_id', $request->school_id)->with('merchant', 'student')->latest('created_at')->paginate(6);

        return TransactionResource::collection($transactions);
    }

    public function getLastFiveTransactions(Request $request): ResourceCollection|JsonResponse
    {
        $transactions = Transaction::where('merchant_id', $request->school_id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();

        return TransactionResource::collection($transactions);
    }

    public static function updateComment(int $transaction_id, string $comment): void
    {
        $transaction = Transaction::where('id', $transaction_id)->first();
        $transactionComment = json_decode($transaction->comment);
        $transactionComment->comment_history[] = $transactionComment->comment;
        $transaction->update([
            'comment' => json_encode([
                'comment' => $comment,
                'comment_history' => $transactionComment->comment_history,
            ]),
        ]);
    }
}
