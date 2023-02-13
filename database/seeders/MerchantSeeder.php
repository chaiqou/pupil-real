<?php

namespace Database\Seeders;

use App\Models\BillingoData;
use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

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
            'finished_onboarding' => 1
        ]);

        $requestBillingoForBlockId1 = Http::withHeaders([
            'X-API-KEY' => env('BILLINGO_API_KEY'),
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();
        $merchant = Merchant::where('id', $merchant_for_levente->id)->first();
        BillingoData::create([
            'block_id' => $requestBillingoForBlockId1['data'][0]['id'],
            'billingo_api_key' => env('BILLINGO_API_KEY'),
            'merchant_id' => $merchant->id,
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
            'finished_onboarding' => 1
        ]);

        $requestBillingoForBlockId2 = Http::withHeaders([
            'X-API-KEY' => env('BILLINGO_API_KEY'),
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();
        $merchant = Merchant::where('id', $merchant_for_nikoloz->id)->first();
        BillingoData::create([
            'block_id' => $requestBillingoForBlockId2['data'][0]['id'],
            'billingo_api_key' => env('BILLINGO_API_KEY'),
            'merchant_id' => $merchant->id,
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
            'finished_onboarding' => 1
        ]);

        $requestBillingoForBlockId3 = Http::withHeaders([
            'X-API-KEY' => env('BILLINGO_API_KEY'),
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();
        $merchant = Merchant::where('id', $merchant_for_luka->id)->first();
        BillingoData::create([
            'block_id' => $requestBillingoForBlockId3['data'][0]['id'],
            'billingo_api_key' => env('BILLINGO_API_KEY'),
            'merchant_id' => $merchant->id,
        ]);
    }
}
