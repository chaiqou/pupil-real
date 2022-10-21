<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		School::create();

		$faker = Factory::create();
		$admin = User::query()->updateOrCreate([
			'first_name'              => 'admin',
			'last_name'               => 'adminlast',
			'school_id'               => 1,
			'billingo_id'             => 1,
			'summary_frequency'       => 1,
			'finished_onboarding'     => 1,
			'user_information'        => json_encode([
				$faker->randomElement(
					[
						'Nikoloz',
						'Levente',
						'Luka',
					]
				),
			]),
			'email'                   => 'info+admin@pupilpay.hu',
			'password'                => bcrypt('pupilpay'),
		])->assignRole('admin');

		$school = User::query()->updateOrCreate([
			'first_name'              => 'school',
			'last_name'               => 'schoollast',
			'school_id'               => 1,
			'billingo_id'             => 2,
			'summary_frequency'       => 2,
			'finished_onboarding'     => 0,
			'user_information'        => json_encode([
				$faker->randomElement(
					[
						'Nikoloz',
						'Levente',
						'Luka',
					]
				),
			]),
			'email'                   => 'info+school@pupilpay.hu',
			'password'                => bcrypt('pupilpay'),
		])->assignRole('school');

		$parent = User::query()->updateOrCreate([
			'first_name'              => 'parent',
			'last_name'               => 'parentlast',
			'school_id'               => 1,
			'billingo_id'             => 3,
			'summary_frequency'       => 1,
			'finished_onboarding'     => 2,
			'user_information'        => json_encode([
				$faker->randomElement(
					[
						'Nikoloz',
						'Levente',
						'Luka',
					]
				),
			]),
			'email'                   => 'info+parent@pupilpay.hu',
			'password'                => bcrypt('pupilpay'),
		])->assignRole('parent');

		$nika = User::query()->updateOrCreate([
			'first_name'              => 'nika',
			'last_name'               => 'lomtadze',
			'school_id'               => 1,
			'billingo_id'             => 1,
			'summary_frequency'       => 1,
			'finished_onboarding'     => 1,
			'user_information'        => json_encode([
				$faker->randomElement(
					[
						'Nikoloz',
						'Levente',
						'Luka',
					]
				),
			]),
			'email'                   => 'lomtadzenikusha@gmail.com',
			'password'                => bcrypt('adminadmin'),
		])->assignRole('school');
	}
}
