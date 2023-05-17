<?php

namespace App\Http\Controllers\School\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Merchant;
use App\Models\PendingTransaction;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionController extends Controller
{
    public function getTransactions(): ResourceCollection|JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $transactions = Transaction::where('merchant_id', $merchant->id)->with('merchant', 'student')->orderByDesc('transaction_date')->paginate(6);

        return TransactionResource::collection($transactions);
    }

    public function getLastFiveTransactions(): ResourceCollection|JsonResponse
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();
        $transactions = Transaction::where('merchant_id', $merchant->id)->orderBy('transaction_date', 'desc')->take(5)->with('merchant', 'student')->get();

        return TransactionResource::collection($transactions);
    }

    public static function updateComment(PendingTransaction $pending_transaction, string $newComment): void
    {
        $transactionComment = json_decode($pending_transaction->comments);
        $transactionComment->comment_history[] = $transactionComment->comment;
        $pending_transaction->update([
            'comments' => json_encode([
                'comment' => $newComment,
                'comment_history' => $transactionComment->comment_history,
            ]),
        ]);
    }
}
