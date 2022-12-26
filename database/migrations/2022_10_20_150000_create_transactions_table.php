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
            $table->foreignId('merchant_id')->constrained();
            $table->date('transaction_date');
            $table->integer('billingo_transaction_id')->nullable();
            $table->integer('amount');
            $table->string('transaction_type');
            $table->enum('payment_status', ["paid", "outstanding", "cancelled", "not_required"]);
            $table->enum('billing_type', ["none", "advance", "invoice", "proforma"]);
            $table->string('billing_comment')->nullable();
            $table->json('billing_item');
            $table->json('comment');
            $table->json('pending');
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
