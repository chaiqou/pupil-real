<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $school = User::create([
            'first_name' => 'School',
            'last_name' => 'School',
            'school_id' => 1,
            'billingo_id' => 1,
            'summary_frequency' => 1,
            'finished_onboarding' => 1,
            'user_information' => json_encode([
                $faker->randomElement(
                    [
                        'Nikoloz',
                        'Levente',
                        'Luka',
                    ]
                ),
            ]),
            'email' => 'info+school@pupilpay.hu',
            'password' => bcrypt('pupilpay'),
        ])->assignRole('school');
    }
}
