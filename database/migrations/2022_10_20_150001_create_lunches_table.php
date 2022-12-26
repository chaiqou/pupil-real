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
            $table->enum('vat', ['0%', '1%', '10%', '11%', '12%', '13%', '14%', '15%', '16%', '17%', '18%', '19%', '2%', '20%', '21%', '22%', '23%', '24%', '25%', '26%', '27%', '3%', '4%', '5%', '5,5%', '6%', '7%', '7,7%', '8%', '9%', '9,5%', 'AAM', 'AM', 'EU', 'EUK', 'F.AFA', 'FAD', 'K.AFA', 'MAA', 'TAM', 'ÁKK', 'ÁTHK'])->default('17%');
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
