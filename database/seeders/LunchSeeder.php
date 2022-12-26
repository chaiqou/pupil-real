<?php

namespace Database\Seeders;

use App\Models\Lunch;
use Illuminate\Database\Seeder;

class LunchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lunch_for_levente = Lunch::create([
            'merchant_id' => 1,
            'name' => 'Levente',
            'description' => 'Levente',
            'period_length' => 'Levente',
            'claimables' => 'Levente',
            'active_range' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'weekdays' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'holds' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'extras' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'available_days' => 'Levente',
            'price_period' => 'Levente',

        ]);

        $lunch_for_luka = Lunch::create([
            'merchant_id' => 2,
            'name' => 'Luka',
            'description' => 'Luka',
            'period_length' => 'Luka',
            'claimables' => 'Luka',
            'active_range' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'weekdays' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'holds' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'extras' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'available_days' => 'Luka',
            'price_period' => 'Luka',

        ]);

        $lunch_for_nikoloz = Lunch::create([
            'merchant_id' => 3,
            'name' => 'Nikoloz',
            'description' => 'Nikoloz',
            'period_length' => 'Nikoloz',
            'claimables' => 'Nikoloz',
            'active_range' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'weekdays' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'holds' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'extras' => [
                'start' => '2021-10-20',
                'end' => '2021-10-20',
            ],
            'available_days' => 'Nikoloz',
            'price_period' => 'Nikoloz',

        ]);
    }
}
