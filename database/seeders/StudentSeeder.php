<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $student_for_nikoloz = Student::create([
			'first_name'              => 'Nikoloz',
			'last_name'               => 'Lomtadze',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
			'school_id'               => 1,
			'user_id'                 => 3,
		]);

		$student_for_nikoloz2 = Student::create([
			'first_name'              => 'Luka',
			'last_name'               => 'Ramishvili',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
			'school_id'               => 1,
			'user_id'                 => 3,
		]);

        $student_for_levente = Student::create([
			'first_name'              => 'Nikoloz',
			'last_name'               => 'Lomtadze',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
			'school_id'               => 1,
			'user_id'                 => 1,
		]);

		$student_for_levente2 = Student::create([
			'first_name'              => 'Luka',
			'last_name'               => 'Ramishvili',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
			'school_id'               => 1,
			'user_id'                 => 1,
		]);

        $student_for_luka = Student::create([
			'first_name'              => 'Nikoloz',
			'last_name'               => 'Lomtadze',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
			'school_id'               => 1,
			'user_id'                 => 2,
		]);

		$student_for_luka2 = Student::create([
			'first_name'              => 'Luka',
			'last_name'               => 'Ramishvili',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
			'school_id'               => 1,
			'user_id'                 => 2,
		]);

        $student_for_school = Student::create([
            'first_name'              => 'Luka',
            'last_name'               => 'Ramishvili',
            'card_number'             => 123456789,
            'card_data'               => 123456789,
            'balances'                => json_encode([
                'balance' => 0,
                'balance_history' => [],
            ]),
            'school_id'               => 1,
            'user_id'                 => 4,
        ]);
    }
}