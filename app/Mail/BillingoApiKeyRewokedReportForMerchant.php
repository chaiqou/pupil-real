<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillingoApiKeyRewokedReportForMerchant extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $merchant, public $language)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.billingo-rewoke-merchant')->subject('Billingo api key report from PupilPay HU');
        }

        return $this->view('mail.en.billingo-rewoke-merchant')->subject('Billingo api key report from PupilPay');
    }
}
