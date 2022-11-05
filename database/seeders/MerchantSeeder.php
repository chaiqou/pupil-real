<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchant_for_levente = Merchant::create([
            'user_id' => 1,
            'billingo_api_key' => '123456789',
            'company_details' => json_encode([
                'company_name' => 'Levente',
            ]),
            'merchant_nick' => 'Cafeteria',
        ]);

        $merchant_for_nikoloz = Merchant::create([
            'user_id' => 2,
            'billingo_api_key' => '1234546789',
            'company_details' => json_encode([
                'company_name' => 'Levente',
            ]),
            'merchant_nick' => 'Cafeteria',
        ]);

        $merchant_for_luka = Merchant::create([
            'user_id' => 3,
            'billingo_api_key' => '12345s6789',
            'company_details' => json_encode([
                'company_name' => 'Levente',
            ]),
            'merchant_nick' => 'Cafeteria',
        ]);
    }
}
