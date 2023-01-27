<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('merchant_id')->constrained();
            $table->string('transaction_identifier');
            $table->date('transaction_date');
            $table->string('transaction_amount');
            $table->string('transaction_type');
            $table->string('comments');
            $table->string('history');
            $table->string('wallet');
            $table->string('stripe_session_id');
            $table->string('payment_method');
            $table->string('billing_items');
            $table->string('billing_provider');
            $table->string('billing_comment');
            $table->string('billing_type');
            $table->integet('proforma_id')->nullable();
            $table->string('convert_to_invoice');
            $table->string('handler_status');
            $table->string('cancelled_status');
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
        Schema::dropIfExists('pending_transactions');
    }
};
