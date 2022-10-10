<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		School::create(['id' => 32]);
		$admin = User::create([
			'first_name'              => 'admin',
			'last_name'               => 'admin',
			'email'                   => 'admin@admin.com',
			'password'                => bcrypt('adminadmin'),
			'school_id'               => 32,
			'billingo_id'             => 1,
			'summary_frequency'       => 3,
			'finished_onboarding'     => 7,
			'user_information'        => null,
			'remember_token'          => 'no',
		]);

		$admin->assignRole('admin');
	}
}
