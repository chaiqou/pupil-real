<?php

namespace App\Console\Commands;

use App\Mail\MerchantBillingoDataReportMail;
use App\Models\Merchant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MerchantToBillingoHealthCheck extends Command
{
    protected $signature = 'billingo:merchant-billingo-data-check';

    protected $description = 'Check if there is any user who is missing billingo_data which is important';

    public function handle()
    {
        $merchants = Merchant::with('billingo_data')->get();

        foreach ($merchants as $merchant) {
            if (! isset($merchant->billingo_data)) {
                Mail::to('info@pupilpay.hu')->send(new MerchantBillingoDataReportMail($merchant));
            }
        }
    }
}
