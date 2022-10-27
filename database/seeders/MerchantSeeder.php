<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
    }
}
