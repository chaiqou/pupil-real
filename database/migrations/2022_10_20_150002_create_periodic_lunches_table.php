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
        Schema::create('periodic_lunches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->string('card_data')->constrained('students', 'card_data');
            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('merchant_id')->constrained();
            $table->foreignId('lunch_id')->constrained();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->enum('payment', ['paid', 'outstanding', 'cancelled', 'not_required']);
            $table->json('claims');
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
        Schema::dropIfExists('periodic_lunches');
    }
};
