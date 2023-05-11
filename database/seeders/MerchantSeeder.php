<?php

namespace Database\Seeders;

use App\Models\BillingoData;
use App\Models\Merchant;
use App\Models\User;
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
        $merchant_for_luka_school_is_oxford_part_1 =
            User::create([
                'first_name' => 'Jack',
                'last_name' => 'Laren',
                'middle_name' => 'Bond',
                'email' => 'lukaramishvili@redberry.ge',
                'password' => bcrypt('123123Aa'),
                'school_id' => 1,
                'stripe_completed' => 1,
                'user_information' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Random Street',
                    'city' => 'Random City',
                    'state' => 'Random State',
                    'zip' => '123',
                ]),
                'finished_onboarding' => 1,
                'summary_frequency' => 1,
            ])->assignRole('school');

        $merchant_for_luka_school_is_oxford_part_2 =
            Merchant::create([
                'finished_onboarding' => 1,
                'merchant_nick' => 'Merchant Nick',
                'company_legal_name' => 'Company Legal Name',
                'user_id' => $merchant_for_luka_school_is_oxford_part_1->id,
                'school_id' => $merchant_for_luka_school_is_oxford_part_1->school_id,
                'company_details' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Random Street Address',
                    'company_name' => 'Company Name',
                    'city' => 'Some City',
                    'state' => 'Some State',
                    'zip' => '1231',
                    'VAT' => '123123',
                ]),
            ]);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $stripeAccount = $stripe->accounts->create([
            'type' => 'express',
            'country' => 'HU',
            'email' => $merchant_for_luka_school_is_oxford_part_1->email,
            'business_type' => 'individual',
            'business_profile' => [
                'product_description' => 'Merchant for the PupilPay Platform.',
            ],
            'company' => [
                'address' => [
                    'city' => 'RandomCity',
                    'country' => 'HU',
                    'line1' => 'Address',
                    'postal_code' => '123',
                    'state' => 'State',
                ],
                'name' => $merchant_for_luka_school_is_oxford_part_2->company_legal_name,
                'vat_id' => '1234',
            ],
            'individual' => [
                'address' => [
                    'city' => 'RandomCity2',
                    'country' => 'HU',
                    'line1' => 'Address3',
                    'postal_code' => '14',
                    'state' => 'State2',
                ],
                'email' => $merchant_for_luka_school_is_oxford_part_1->email,
                'first_name' => $merchant_for_luka_school_is_oxford_part_1->first_name,
                'last_name' => $merchant_for_luka_school_is_oxford_part_1->last_name,
            ],
        ]);
        $merchant_for_luka_school_is_oxford_part_2->update([
            'stripe_account_id' => $stripeAccount->id,
        ]);

        $requestBillingo = Http::withHeaders([
            'X-API-KEY' => config('services.billingo.key'),
        ])->get('https://api.billingo.hu/v3/utils/time');
        $requestBillingoForBlockId = Http::withHeaders([
            'X-API-KEY' => config('services.billingo.key'),
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();
        if ($requestBillingo->status() === 200) {
            BillingoData::create([
                'block_id' => $requestBillingoForBlockId['data'][0]['id'],
                'billingo_api_key' => config('services.billingo.key'),
                'merchant_id' => $merchant_for_luka_school_is_oxford_part_2->id,
            ]);
        }

        $merchant_for_nikoloz_school_is_oxford_part_1 =
            User::create([
                'first_name' => 'MerchantNika',
                'last_name' => 'Lome',
                'middle_name' => null,
                'email' => 'nikolozlomtadze@redberry.ge',
                'password' => bcrypt('123123Aa'),
                'school_id' => 1,
                'stripe_completed' => 1,
                'user_information' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Avenue 35',
                    'city' => 'Anders',
                    'state' => 'Menga',
                    'zip' => '515',
                ]),
                'finished_onboarding' => 1,
                'summary_frequency' => 1,
            ])->assignRole('school');

        $merchant_for_nikoloz_school_is_oxford_part_2 =
            Merchant::create([
                'finished_onboarding' => 1,
                'merchant_nick' => 'Super Cafe',
                'company_legal_name' => 'LegalNameOOS',
                'user_id' => $merchant_for_nikoloz_school_is_oxford_part_1->id,
                'school_id' => $merchant_for_nikoloz_school_is_oxford_part_1->school_id,
                'company_details' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Random Street Address',
                    'company_name' => 'Company Name',
                    'city' => 'Some City',
                    'state' => 'Some State',
                    'zip' => '1231',
                    'VAT' => '123123',
                ]),
            ]);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $stripeAccount = $stripe->accounts->create([
            'type' => 'express',
            'country' => 'HU',
            'email' => $merchant_for_nikoloz_school_is_oxford_part_1->email,
            'business_type' => 'individual',
            'business_profile' => [
                'product_description' => 'Merchant for the PupilPay Platform.',
            ],
            'company' => [
                'address' => [
                    'city' => 'RandomCity',
                    'country' => 'HU',
                    'line1' => 'Address',
                    'postal_code' => '123',
                    'state' => 'State',
                ],
                'name' => $merchant_for_nikoloz_school_is_oxford_part_2->company_legal_name,
                'vat_id' => '1234',
            ],
            'individual' => [
                'address' => [
                    'city' => 'RandomCity2',
                    'country' => 'HU',
                    'line1' => 'Address3',
                    'postal_code' => '14',
                    'state' => 'State2',
                ],
                'email' => $merchant_for_nikoloz_school_is_oxford_part_1->email,
                'first_name' => $merchant_for_nikoloz_school_is_oxford_part_1->first_name,
                'last_name' => $merchant_for_nikoloz_school_is_oxford_part_1->last_name,
            ],
        ]);
        $merchant_for_nikoloz_school_is_oxford_part_2->update([
            'stripe_account_id' => $stripeAccount->id,
        ]);

        $requestBillingo = Http::withHeaders([
            'X-API-KEY' => config('services.billingo.key'),
        ])->get('https://api.billingo.hu/v3/utils/time');
        $requestBillingoForBlockId = Http::withHeaders([
            'X-API-KEY' => config('services.billingo.key'),
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();
        if ($requestBillingo->status() === 200) {
            BillingoData::create([
                'block_id' => $requestBillingoForBlockId['data'][0]['id'],
                'billingo_api_key' => config('services.billingo.key'),
                'merchant_id' => $merchant_for_nikoloz_school_is_oxford_part_2->id,
            ]);
        }

        $merchant_for_levente_school_is_oxford_part_1 =
            User::create([
                'first_name' => 'MerchantLevente',
                'last_name' => 'Pup',
                'middle_name' => null,
                'email' => 'klevente@pupilpay.hu',
                'password' => bcrypt('123123Aa'),
                'school_id' => 1,
                'stripe_completed' => 1,
                'user_information' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Street 75',
                    'city' => 'Ben',
                    'state' => 'MaState',
                    'zip' => '3418',
                ]),
                'finished_onboarding' => 1,
                'summary_frequency' => 1,
            ])->assignRole('school');

        $merchant_for_levente_school_is_oxford_part_2 =
            Merchant::create([
                'finished_onboarding' => 1,
                'merchant_nick' => 'Maximal Cafeteria',
                'company_legal_name' => 'Legal Company Name KLP',
                'user_id' => $merchant_for_levente_school_is_oxford_part_1->id,
                'school_id' => $merchant_for_levente_school_is_oxford_part_1->school_id,
                'company_details' => json_encode([
                    'country' => 'HU',
                    'street_address' => 'Random Street Address3',
                    'company_name' => 'Company Name5',
                    'city' => 'Some City7',
                    'state' => 'Some State8',
                    'zip' => '55',
                    'VAT' => '32321',
                ]),
            ]);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $stripeAccount = $stripe->accounts->create([
            'type' => 'express',
            'country' => 'HU',
            'email' => $merchant_for_levente_school_is_oxford_part_1->email,
            'business_type' => 'individual',
            'business_profile' => [
                'product_description' => 'Merchant for the PupilPay Platform.',
            ],
            'company' => [
                'address' => [
                    'city' => 'RandomCity',
                    'country' => 'HU',
                    'line1' => 'Address',
                    'postal_code' => '123',
                    'state' => 'State',
                ],
                'name' => $merchant_for_levente_school_is_oxford_part_2->company_legal_name,
                'vat_id' => '1234',
            ],
            'individual' => [
                'address' => [
                    'city' => 'RandomCity2',
                    'country' => 'HU',
                    'line1' => 'Address3',
                    'postal_code' => '14',
                    'state' => 'State2',
                ],
                'email' => $merchant_for_levente_school_is_oxford_part_1->email,
                'first_name' => $merchant_for_levente_school_is_oxford_part_1->first_name,
                'last_name' => $merchant_for_levente_school_is_oxford_part_1->last_name,
            ],
        ]);
        $merchant_for_levente_school_is_oxford_part_2->update([
            'stripe_account_id' => $stripeAccount->id,
        ]);

        $requestBillingo = Http::withHeaders([
            'X-API-KEY' => config('services.billingo.key'),
        ])->get('https://api.billingo.hu/v3/utils/time');
        $requestBillingoForBlockId = Http::withHeaders([
            'X-API-KEY' => config('services.billingo.key'),
        ])->get('https://api.billingo.hu/v3/document-blocks?page=1&per_page=25&type=invoice')->json();
        if ($requestBillingo->status() === 200) {
            BillingoData::create([
                'block_id' => $requestBillingoForBlockId['data'][0]['id'],
                'billingo_api_key' => config('services.billingo.key'),
                'merchant_id' => $merchant_for_levente_school_is_oxford_part_2->id,
            ]);
        }
    }
}
