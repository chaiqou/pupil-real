<?php

//
//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
//
//return new class() extends Migration {
//	/**
//	 * Run the migrations.
//	 *
//	 * @return void
//	 */
//	public function up()
//	{
//		Schema::create('users', function (Blueprint $table) {
//			$table->id();
//<<<<<<< HEAD
//			$table->string('first_name')->default('unfilled');
//			$table->string('last_name')->default('unfilled');
//			$table->string('email')->unique();
//			$table->string('password');
//			$table->foreignId('school_id')->default(1)->constrained();
//			$table->tinyInteger('billingo_id')->default(0);
//			$table->tinyInteger('summary_frequency')->default(0);
//			$table->tinyInteger('finished_onboarding')->default(0);
//			$table->json('user_information')->nullable();
//=======
//			$table->string('first_name');
//			$table->string('last_name');
//			$table->string('middle_name')->nullable();
//			$table->string('email')->unique();
//			$table->string('password');
//			$table->foreignId('school_id')->constrained();
//			$table->integer('billingo_id');
//			$table->tinyInteger('summary_frequency');
//			$table->tinyInteger('finished_onboarding');
//			$table->json('user_information');
//			$table->string('token')->nullable()->unique();
//>>>>>>> 96d268771548e2513371c772d8b22a3de3f1edef
//			$table->rememberToken();
//			$table->timestamps();
//		});
//	}
//
//	/**
//	 * Reverse the migrations.
//	 *
//	 * @return void
//	 */
//	public function down()
//	{
//		Schema::dropIfExists('users');
//	}
//};
