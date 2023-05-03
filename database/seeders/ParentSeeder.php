<?php

namespace Database\Seeders;

use App\Http\Controllers\BillingoController;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_for_luka_merchant_is_lukaMerchant =
            User::create([
                'last_name' => 'Ramishvili',
                'first_name' => 'Luka',
                'middle_name' => null,
                'school_id' => 1,
                'email' => 'jackrestlertesting@gmail.com',
                'password' => bcrypt('123123Aa'),
                'finished_onboarding' => '1',
                'user_information' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Street',
                    'city' => 'City',
                    'state' => 'State',
                    'zip' => '321',
                ]),
            ])->assignRole('parent');

        $luka_stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $lukaStripeCustomerRequest = $luka_stripe->customers->create([
            'address' => [
                'city' => 'City',
                'line1' => 'MonteCarlo',
                'postal_code' => '678',
                'state' => 'State',
            ],
            'email' => $parent_for_luka_merchant_is_lukaMerchant->email,
            'name' => $parent_for_luka_merchant_is_lukaMerchant->last_name.' '.$parent_for_luka_merchant_is_lukaMerchant->first_name.' '.$parent_for_luka_merchant_is_lukaMerchant->middle_name,
        ]);

        $parent_for_luka_merchant_is_lukaMerchant->update([
            'stripe_customer_id' => $lukaStripeCustomerRequest->id,
        ]);

        BillingoController::createParentBillingo($parent_for_luka_merchant_is_lukaMerchant->id);
    }
}
