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

		$levente = User::create([
			'first_name'              => 'Levente',
			'last_name'               => 'Kazo',
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
			'email'                   => 'klevente@pupilpay.hu',
			'password'                => bcrypt('pupilpay'),
		])->assignRole('parent');

        $luka = User::create([
			'first_name'              => 'Luka',
			'last_name'               => 'Ramishvili',
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
			'email'                   => 'jackrestler@gmail.com',
			'password'                => bcrypt('adminadmin'),
		])->assignRole('parent');

		$nikoloz = User::create([
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
		])->assignRole('parent');

        $school = User::create([
            'first_name'              => 'School',
            'last_name'               => 'School',
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
            'email'                   => 'school@gmail.com',
            'password'                => bcrypt('adminadmin'),
        ])->assignRole('school');

	}


}


