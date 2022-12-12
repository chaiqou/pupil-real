<?php

namespace Database\Seeders;

use App\Models\School;
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

        $levente = User::create([
            'first_name' => 'Levente',
            'last_name' => 'Kazo',
            'school_id' => 1,
            'billingo_id' => 1,
            'summary_frequency' => 1,
            'finished_onboarding' => 1,
            'user_information' => json_encode([
                'country' => 'HU',
                'state' => 'RansomState',
                'city' => 'RandomCity',
                'street_address' => 'Random str.15',
                'zip' => '99212',
            ]),
            'email' => 'klevente@pupilpay.hu',
            'password' => bcrypt('pupilpay'),
        ])->assignRole('parent');

        $luka = User::create([
            'first_name' => 'Luka',
            'last_name' => 'Ramishvili',
            'school_id' => 1,
            'billingo_id' => 1,
            'summary_frequency' => 1,
            'finished_onboarding' => 1,
            'user_information' => json_encode([
                'country' => 'HU',
                'state' => 'RansomState',
                'city' => 'RandomCity',
                'street_address' => 'Random str.15',
                'zip' => '99212',
            ]),
            'email' => 'jackrestler@gmail.com',
            'password' => bcrypt('adminadmin'),
        ])->assignRole('parent');

        $nikoloz = User::create([
            'first_name' => 'nika',
            'last_name' => 'lomtadze',
            'school_id' => 1,
            'billingo_id' => 1,
            'summary_frequency' => 1,
            'finished_onboarding' => 1,
            'user_information' => json_encode([
                'country' => 'HU',
                'state' => 'RansomState',
                'city' => 'RandomCity',
                'street_address' => 'Random str.15',
                'zip' => '99212',
            ]),
            'email' => 'lomtadzenikusha@gmail.com',
            'password' => bcrypt('adminadmin'),
        ])->assignRole('school');

        $admin = User::create([
            'first_name' => 'AdminF',
            'last_name' => 'AdminL',
            'school_id' => 1,
            'billingo_id' => 1,
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
        ])->assignRole('admin');
    }
}
