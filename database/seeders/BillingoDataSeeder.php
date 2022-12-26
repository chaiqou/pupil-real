<?php

namespace Database\Seeders;

use App\Models\BillingoData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillingoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $billingoDataOne = BillingoData::create([
            'merchant_id' => 1,
            'block_id' => 123852,
            'billingo_api_key' => 'aff49ffc-74a6-11ed-878b-0254eb6072a0',
        ]);
        $billingoDataOne = BillingoData::create([
            'merchant_id' => 2,
            'block_id' => 123852,
            'billingo_api_key' => 'aff49ffc-74a6-11ed-878b-0254eb6072a0',
        ]);
        $billingoDataOne = BillingoData::create([
            'merchant_id' => 3,
            'block_id' => 123852,
            'billingo_api_key' => 'aff49ffc-74a6-11ed-878b-0254eb6072a0',
        ]);
    }
}
