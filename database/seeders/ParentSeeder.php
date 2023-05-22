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
            ])->assignRole('parent', '2fa');

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

        BillingoController::createOrUpdateParentBillingo($parent_for_luka_merchant_is_lukaMerchant->id);

        $parent_for_nikoloz_merchant_is_nikolozMerchant =
            User::create([
                'last_name' => 'Lomtadze',
                'first_name' => 'Nikusha',
                'middle_name' => null,
                'school_id' => 1,
                'email' => 'nikolozlomtadze0@gmail.com',
                'password' => bcrypt('123123Aa'),
                'finished_onboarding' => '1',
                'user_information' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Street',
                    'city' => 'City',
                    'state' => 'State',
                    'zip' => '321',
                ]),
            ])->assignRole('parent', '2fa');

        $nikoloz_stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $nikolozStripeCustomerRequest = $nikoloz_stripe->customers->create([
            'address' => [
                'city' => 'City',
                'line1' => 'MonteCarlovich',
                'postal_code' => '3378',
                'state' => 'State',
            ],
            'email' => $parent_for_nikoloz_merchant_is_nikolozMerchant->email,
            'name' => $parent_for_nikoloz_merchant_is_nikolozMerchant->last_name.' '.$parent_for_nikoloz_merchant_is_nikolozMerchant->first_name.' '.$parent_for_nikoloz_merchant_is_nikolozMerchant->middle_name,
        ]);

        $parent_for_nikoloz_merchant_is_nikolozMerchant->update([
            'stripe_customer_id' => $nikolozStripeCustomerRequest->id,
        ]);

        BillingoController::createOrUpdateParentBillingo($parent_for_nikoloz_merchant_is_nikolozMerchant->id);

        $parent_for_levente_merchant_is_leventeMerchant =
            User::create([
                'last_name' => 'Kazó',
                'first_name' => 'Levente',
                'middle_name' => null,
                'school_id' => 1,
                'email' => 'kazo.levente@gmail.com',
                'password' => bcrypt('123123Aa'),
                'finished_onboarding' => '1',
                'user_information' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Street',
                    'city' => 'City',
                    'state' => 'State',
                    'zip' => '321',
                ]),
            ])->assignRole('parent', '2fa');

        $levente_stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $leventeStripeCustomerRequest = $levente_stripe->customers->create([
            'address' => [
                'city' => 'City',
                'line1' => 'MonteCarlovich',
                'postal_code' => '3378',
                'state' => 'State',
            ],
            'email' => $parent_for_levente_merchant_is_leventeMerchant->email,
            'name' => $parent_for_levente_merchant_is_leventeMerchant->last_name.' '.$parent_for_levente_merchant_is_leventeMerchant->first_name.' '.$parent_for_levente_merchant_is_leventeMerchant->middle_name,
        ]);

        $parent_for_levente_merchant_is_leventeMerchant->update([
            'stripe_customer_id' => $leventeStripeCustomerRequest->id,
        ]);

        BillingoController::createOrUpdateParentBillingo($parent_for_levente_merchant_is_leventeMerchant->id);
    }
}
