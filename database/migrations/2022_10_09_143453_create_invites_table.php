<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invites', function (Blueprint $table) {
			$table->id();
			$table->string('uniqueID')->unique();
			$table->string('email')->unique();
			$table->foreignID('school_id')->default(1)->constrained()->cascadeOnDelete();
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
		Schema::dropIfExists('invites');
	}
};
