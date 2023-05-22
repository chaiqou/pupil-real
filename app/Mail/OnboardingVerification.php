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

    public function __construct(public $inviteCode, public $user, public $language)
    {
        //
    }

    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.onboarding-verification')->subject('Ellenőrzés a PupilPay-hez');
        }

        return $this->view('mail.en.onboarding-verification')->subject('Verification for PupilPay');
    }
}
