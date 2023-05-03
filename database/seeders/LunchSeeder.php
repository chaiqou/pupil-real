<?php

namespace Database\Seeders;

use App\Models\Lunch;
use App\Models\Merchant;
use App\Models\User;
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
        function get_dates_until_end_of_month(): array
        {
            $today = date('Y-m-d');
            $last_day = date('t', strtotime($today));
            $dates = [];
            for ($i = 0; $i < $last_day; $i++) {
                $dates[] = date('Y-m-d', strtotime($today." + $i day"));
            }

            return $dates;
        }

        $lukaMerchantUser = User::where('email', 'lukaramishvili@redberry.ge')->first();
        $lukaMerchant = Merchant::where('user_id', $lukaMerchantUser->id)->first();
        $lunch_for_luka_merchant_1 = Lunch::create([
            'merchant_id' => $lukaMerchant->id,
            'title' => 'LunchNumberOne',
            'description' => 'Some good lunch with good stuff',
            'active_range' => ['2023-05-03', '2023-05-31'],
            'period_length' => '1',
            'claimables' => ['Lunch'],
            'holds' => null,
            'extras' => null,
            'weekdays' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'available_days' => get_dates_until_end_of_month(),
            'price_period' => rand(0, 396),
            'buffer_time' => 1,
            'vat' => '27%',
        ]);

        $lunch_for_luka_merchant_2 = Lunch::create([
            'merchant_id' => $lukaMerchant->id,
            'title' => 'SuperBreakfast',
            'description' => 'Amazing lunch!',
            'active_range' => get_dates_until_end_of_month(),
            'period_length' => '1',
            'claimables' => ['Lunch'],
            'holds' => null,
            'extras' => null,
            'weekdays' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'available_days' => get_dates_until_end_of_month(),
            'price_period' => rand(176, 396),
            'buffer_time' => 1,
            'vat' => '5%',
        ]);
    }
}
