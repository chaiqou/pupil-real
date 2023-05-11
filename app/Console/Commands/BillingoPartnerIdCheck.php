<?php

namespace App\Console\Commands;

use App\Mail\PartnerIdRewokedReportForAdmin;
use App\Mail\PartnerIdRewokedReportForParent;
use App\Models\BillingoData;
use App\Models\PartnerId;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class BillingoPartnerIdCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:billingo-partner-id-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check which partnerId-s is incorrect or rewoked (deleted) from Billingo system, if so, make billingo_suspended => true';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $partnerIds = PartnerId::all();
        foreach ($partnerIds as $partnerId) {
            $merchantBillingoData = BillingoData::where('merchant_id', $partnerId->merchant_id)->first();
            $response = Http::withHeaders([
                'X-API-KEY' => $merchantBillingoData->billingo_api_key,
            ])->get('https://api.billingo.hu/v3/partners/'.$partnerId->partner_id);

            if ($response->status() === 403) {
                // partner_id is forbidden, probably revoked or incorrect
                $user = User::where('id', $partnerId->user_id)->first();
                $partnerId->update([
                    'billingo_suspended' => true,
                ]);
                $this->info('Partner ID for parent which id is # '.$partnerId->user_id.'is probably rewoked or incorrect, sending reports to current parent and admin...');
                Mail::to('info@pupilpay.hu')->send(new PartnerIdRewokedReportForAdmin($user));
                $this->info('Email for admin sent');
                Mail::to($user->email)->send(new PartnerIdRewokedReportForParent($user, $user->language));
                $this->info('Email for parent sent');
            } else {
                $this->info('Partner ID for parent which id is # '.$partnerId->user_id.' is working');
            }
        }
    }
}
