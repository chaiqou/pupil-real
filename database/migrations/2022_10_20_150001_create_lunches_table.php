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
        Schema::create('lunches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->integer('period_length');
            $table->json('weekdays');
            $table->json('active_range');
            $table->json('claimables');
            $table->json('holds')->nullable();
            $table->json('extras')->nullable();
            $table->json('available_days');
            $table->integer('buffer_time');
            $table->integer('price_day');
            $table->integer('price_period');
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
        Schema::dropIfExists('lunches');
    }
};
