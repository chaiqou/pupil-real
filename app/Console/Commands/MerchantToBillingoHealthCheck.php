<?php

namespace App\Console\Commands;

use App\Mail\MerchantBillingoDataReportMail;
use App\Models\Merchant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MerchantToBillingoHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:merchant-billingo-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
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
