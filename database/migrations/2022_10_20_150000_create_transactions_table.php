<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('merchant_id')->constrained();
            $table->string('transaction_identifier');
            $table->date('transaction_date');
            $table->bigInteger('transaction_amount');
            $table->enum('transaction_type',["payment", "storno", "top_up"]);
            $table->json('comments')->default(json_encode(['comments' => ['comment' => null, 'comment_by' => null, 'comment_at' => null]]));
            $table->json('history')->default(json_encode(['history' => ['data' => null, 'data_by' => null, 'data_at' => null]]));
            $table->string('wallet_id')->nullable();
            /* Update wallet to be constrained to wallet table */
            $table->string('stripe_session_id')->nullable();
            $table->enum('payment_method',["stripe", "bank_transfer", "wallet", "other", "none"]);
            $table->json('billing_items')->nullable();
            $table->enum('billing_provider',["none","billingo"]);
            $table->json('billing_comment')->nullable();
            $table->integer('invoice_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
