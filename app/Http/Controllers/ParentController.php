<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parent\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ParentController extends Controller
{
    public function getTransactions(TransactionRequest $request): ResourceCollection|JsonResponse
    {
        $transactions = Transaction::where('student_id', $request->user_id)->with('merchant', 'student')->get();
        return TransactionResource::collection($transactions);
    }
}
