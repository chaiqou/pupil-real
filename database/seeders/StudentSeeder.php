<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lukaParent = User::where('email', 'jackrestlertesting@gmail.com')->first();
        $student_for_lukaParent_1 =
            Student::create([
                'first_name' => 'Borok',
                'last_name' => 'Menres',
                'middle_name' => null,
                'card_number' => null,
                'card_data' => null,
                'user_id' => $lukaParent->id,
                'school_id' => $lukaParent->school_id,
                'user_information' => json_encode([
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '123',
                    'state' => 'state',
                ]),
            ]);
    }
}
