<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillingoApiKeyRewokedReportForAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $merchant)
    {
    }

    public function build()
    {
        return $this->view('mail.billingo-rewoke-admin')->subject('Billingo api key report from PupilPay');
    }
}
