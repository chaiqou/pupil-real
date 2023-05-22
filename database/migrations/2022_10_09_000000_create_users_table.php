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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->default('unfilled');
            $table->string('last_name')->default('unfilled');
            $table->string('middle_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->foreignId('school_id')->nullable()->constrained();
            $table->tinyInteger('summary_frequency')->default(0);
            $table->tinyInteger('finished_onboarding')->default(0);
            $table->json('user_information')->nullable();
            $table->string('two_factor_code')->nullable()->unique();
            $table->string('language')->default('en');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
