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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_nick');
            $table->string('company_legal_name');
            $table->boolean('activated')->default(false);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('school_id')->constrained();
            $table->string('stripe_account_id')->nullable();
            $table->boolean('stripe_completed')->default(false);
            $table->boolean('has_wallet')->default(false);
            $table->boolean('has_lunch')->default(false);
            $table->json('company_details');
            $table->boolean('finished_onboarding')->default(0);
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
        Schema::dropIfExists('merchants');
    }
};
