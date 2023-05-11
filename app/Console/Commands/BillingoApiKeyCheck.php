<?php

namespace App\Console\Commands;

use App\Mail\BillingoApiKeyRewokedReportForAdmin;
use App\Mail\BillingoApiKeyRewokedReportForMerchant;
use App\Models\BillingoData;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class BillingoApiKeyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:check-billingo-api-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if Billingo Api Key is rewoked (deleted) or not by the merchant, if so, send email to them and to us with report about this';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $billingoDatas = BillingoData::all();

        foreach ($billingoDatas as $billingoData) {
            $response = Http::withHeaders([
                'X-API-KEY' => $billingoData->billingo_api_key,
            ])->get('https://api.billingo.hu/v3/utils/time');

            if ($response->status() === 401) {
                // API key is unauthorized, probably revoked
                $merchant = Merchant::where('id', $billingoData->merchant_id)->first();
                $userId = $merchant->user_id;
                $user = User::where('id', $userId)->first();
                $billingoData->update([
                    'billingo_suspended' => true,
                ]);
                $this->info('Billingo api key for merchant id # '.$billingoData->merchant_id.'is probably rewoked, sending reports to current merchant and admin...');
                Mail::to('info@pupilpay.hu')->send(new BillingoApiKeyRewokedReportForAdmin($merchant));
                $this->info('Email for admin sent');
                Mail::to($user->email)->send(new BillingoApiKeyRewokedReportForMerchant($merchant, $user->language));
                $this->info('Email for merchant sent');
            } else {
                $this->info('Billingo api key for merchant id # '.$billingoData->merchant_id.' is working');
            }
        }
    }
}
