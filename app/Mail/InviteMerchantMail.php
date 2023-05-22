<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMerchantMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $invite, public $language)
    {
    }

    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.invite-merchant')->subject('PupilPay meghívó');
        }

        return $this->view('mail.en.invite-merchant')->subject('Invitation to PupilPay');
    }
}
