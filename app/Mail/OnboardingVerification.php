<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnboardingVerification extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $inviteCode, public $user, public $language)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.onboarding-verification')->subject('Verification for PupilPay HU');
        }

        return $this->view('mail.en.onboarding-verification')->subject('Verification for PupilPay');
    }
}
