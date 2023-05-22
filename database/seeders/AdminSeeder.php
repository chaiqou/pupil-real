<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
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
        $faker = Factory::create();

        $nikoloz_admin = User::create([
            'first_name' => 'Nikoloz',
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
            'email' => 'lomtadzenikusha@gmail.com',
            'password' => bcrypt('adminadmin'),
            'language' => 'en',
        ])->assignRole('admin', '2fa');

        $levente_admin = User::create([
            'first_name' => 'Levente',
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
            'email' => 'info+admin@pupilpay.hu',
            'password' => bcrypt('adminadmin'),
            'language' => 'en',
        ])->assignRole('admin', '2fa');

        $luka_admin = User::create([
            'first_name' => 'Luka',
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
            'email' => 'jackrestler@gmail.com',
            'password' => bcrypt('adminadmin'),
            'language' => 'en',
        ])->assignRole('admin', '2fa');
    }
}
