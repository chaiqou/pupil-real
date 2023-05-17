<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MerchantBillingoDataReportMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public $merchant)
    {
        //
    }

    public function build()
    {
        return $this->view('mail.merchant-billingo-data-report')->subject('PupilPay Report for merchant billingo data');
    }
}
