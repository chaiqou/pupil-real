<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
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
        $faker = Factory::create();

        $admin = User::create([
            'first_name' => 'Main',
            'last_name' => 'Admin',
            'school_id' => null,
            'summary_frequency' => 1,
            'finished_onboarding' => 1,
            'user_information' => json_encode([
                'country' => 'HU',
                'state' => 'RansomState',
                'city' => 'RandomCity',
                'street_address' => 'Random btr.33',
                'zip' => '9',
            ]),
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminadmin'),
            'language' => 'en',
        ])->assignRole('admin');

    }
}
