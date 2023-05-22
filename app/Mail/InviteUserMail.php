<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $invite, public $language)
    {
    }

    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.invite-user')->subject('PupilPay meghívó');
        }

        return $this->view('mail.en.invite-user')->subject('Invitation to PupilPay');
    }
}
