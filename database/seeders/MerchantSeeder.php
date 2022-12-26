<?php

namespace Database\Seeders;

use App\Models\BillingoData;
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
            'school_id' => 1,
            'company_legal_name' => 'Legal name',
            'activated' => true,
            'company_details' => json_encode([
                'company_name' => 'Merki',
                'street_address' => null,
                'VAT' => null,
                'country' => null,
                'city' => 'ExampleCity2',
                'state' => 'ExampleState2',
                'zip' => null,
            ]),
            'merchant_nick' => 'Cafeteria',
        ]);

        $merchant_for_nikoloz = Merchant::create([
            'user_id' => 2,
            'school_id' => 1,
            'company_legal_name' => 'Legal name',
            'activated' => false,
            'company_details' => json_encode([
                'company_name' => 'Bondealis',
                'street_address' => null,
                'VAT' => null,
                'country' => null,
                'city' => 'ExampleCity2',
                'state' => 'ExampleState2',
                'zip' => null,
            ]),
            'merchant_nick' => 'Will Stone',
        ]);

        $merchant_for_luka = Merchant::create([
            'user_id' => 3,
            'school_id' => 2,
            'company_legal_name' => 'Legal name',
            'activated' => true,
            'company_details' => json_encode([
                'company_name' => 'Winston',
                'street_address' => '',
                'VAT' => '',
            ]),
            'merchant_nick' => 'White Bamboo',
        ]);
    }
}
