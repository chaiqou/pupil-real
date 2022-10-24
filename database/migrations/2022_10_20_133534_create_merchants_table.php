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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_nick');
            $table->foreignId('user_id')->constrained();
            $table->string('billingo_api_key');
            $table->boolean('has_balance')->default(false);
            $table->boolean('has_lunch')->default(false);
            $table->json('company_details');
            $table->integer('private_key')->nullable();
            $table->integer('public_key')->nullable();
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
