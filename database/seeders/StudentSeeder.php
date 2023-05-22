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
                'user_information' => [
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '123',
                    'state' => 'state',
                ],
            ]);

        $student_for_lukaParent_2 =
            Student::create([
                'first_name' => 'Mercedes',
                'last_name' => 'Hermes',
                'middle_name' => null,
                'card_number' => null,
                'card_data' => null,
                'user_id' => $lukaParent->id,
                'school_id' => $lukaParent->school_id,
                'user_information' => [
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '123',
                    'state' => 'state',
                ],
            ]);

        $nikolozParent = User::where('email', 'nikolozlomtadze0@gmail.com')->first();
        $student_for_nikolozParent_1 =
            Student::create([
                'first_name' => 'SonOfNikoloz',
                'last_name' => 'Good',
                'middle_name' => null,
                'card_number' => null,
                'card_data' => null,
                'user_id' => $nikolozParent->id,
                'school_id' => $nikolozParent->school_id,
                'user_information' => [
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '123',
                    'state' => 'state',
                ],
            ]);

        $student_for_nikolozParent_2 =
            Student::create([
                'first_name' => 'Narancha',
                'last_name' => 'Golden',
                'middle_name' => null,
                'card_number' => null,
                'card_data' => null,
                'user_id' => $nikolozParent->id,
                'school_id' => $nikolozParent->school_id,
                'user_information' => [
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '123',
                    'state' => 'state',
                ],
            ]);

        $leventeParent = User::where('email', 'kazo.levente@gmail.com')->first();

        $student_for_leventeParent_1 =
            Student::create([
                'first_name' => 'Folkus',
                'last_name' => 'Kazó',
                'middle_name' => null,
                'card_number' => null,
                'card_data' => null,
                'user_id' => $leventeParent->id,
                'school_id' => $leventeParent->school_id,
                'user_information' => [
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '323',
                    'state' => 'state',
                ],
            ]);

        $student_for_leventeParent_2 =
            Student::create([
                'first_name' => 'SonOfLevente',
                'last_name' => 'Levan',
                'middle_name' => null,
                'card_number' => null,
                'card_data' => null,
                'user_id' => $leventeParent->id,
                'school_id' => $leventeParent->school_id,
                'user_information' => [
                    'country' => 'HU',
                    'city' => 'City',
                    'street_address' => 'StreetAddress',
                    'zip' => '523',
                    'state' => 'state',
                ],
            ]);
    }
}
