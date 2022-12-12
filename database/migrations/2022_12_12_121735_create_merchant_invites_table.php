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
        Schema::create('merchant_invites', function (Blueprint $table) {
            $table->id();
            $table->string('uniqueID')->unique();
            $table->string('email')->unique();
            $table->foreignID('school_id')->constrained()->cascadeOnDelete();
            $table->integer('state')->default(0);
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
        Schema::dropIfExists('merchant_invites');
    }
};
