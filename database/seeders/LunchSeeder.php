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
         $oxford_lunch = Lunch::create([
            'merchant_id' => 1,
            'title' => 'Some random title lunch',
            'description' => 'Description123123',
             'period_length' => 4,
             'weekdays' => json_encode([
                 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',
             ]),
             'active_range' => json_encode([
                 '2023-01-09', '2023-01-31'
             ]),
             'claimables' => json_encode([
                 'Beverage',
                 'Breakfast',
                 'Bread',
                 'Appetizer'
             ]),
             'holds' => [],
             'extras' => [],
             'available_days' => json_encode([
                 "2023-01-09","2023-01-16","2023-01-23","2023-01-30","2023-01-10","2023-01-17","2023-01-24","2023-01-31","2023-01-11","2023-01-18","2023-01-25","2023-01-12","2023-01-19","2023-01-26","2023-01-13","2023-01-20","2023-01-27","2023-01-14","2023-01-21","2023-01-28"
             ]),
             'buffer_time' => 4,
             'vat' => '27%',
             'price_period' => 89,
         ]);
    }
}
