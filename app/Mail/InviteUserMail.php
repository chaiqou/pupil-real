<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $invite, public $language)
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
            return $this->view('mail.hu.invite-user')->subject('Invitation to PupilPay HU');
        }

        return $this->view('mail.en.invite-user')->subject('Invitation to PupilPay');
    }
}
