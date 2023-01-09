<?php

namespace Database\Seeders;

use App\Http\Controllers\BillingoController;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parentLevente = User::where('email', 'kazo.levente@gmail.com')->first();
        $parentLeventePartnerId = BillingoController::createParentBillingo($parentLevente->id);
    }
}
