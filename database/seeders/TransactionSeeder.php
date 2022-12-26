<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions_for_levente = Transaction::create([
            'student_id' => 1,
            'merchant_id' => 1,
            'transaction_date' => '2021-10-20',
            'billingo_transaction_id' => 123456789,
            'amount' => 1000,
            'transaction_type' => 'debit',
            'pending' => json_encode([
                'pending' => 0,
                'pending_history' => [],
            ]),
            'billing_items' => json_encode([
              'item' => 1,
            ]),
            'comment' => json_encode([
                'comment' => 0,
                'comment_history' => [],
            ]),
        ]);

        $transactions_for_luka = Transaction::create([
            'student_id' => 2,
            'merchant_id' => 1,
            'transaction_date' => '2021-10-20',
            'billingo_transaction_id' => 123456789,
            'amount' => 1000,
            'transaction_type' => 'debit',
            'pending' => json_encode([
                'pending' => 0,
                'pending_history' => [],
            ]),
            'billing_items' => json_encode([
                'item' => 1,
              ]),
            'comment' => json_encode([
                'comment' => 0,
                'comment_history' => [],
            ]),
        ]);

        $transactions_for_nikoloz = Transaction::create([
            'student_id' => 3,
            'merchant_id' => 1,
            'transaction_date' => '2021-10-20',
            'billingo_transaction_id' => 123456789,
            'amount' => 1000,
            'transaction_type' => 'debit',
            'pending' => json_encode([
                'pending' => 0,
                'pending_history' => [],
            ]),
            'billing_items' => json_encode([
                'item' => 1,
              ]),
            'comment' => json_encode([
                'comment' => 0,
                'comment_history' => [],
            ]),
        ]);
    }
}
