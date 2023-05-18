<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerIdRewokedReportForParent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $user, public $language)
    {
    }

    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.partner-id-rewoke-parent')->subject('Partner ID jelentés a PupilPay-től');
        }

        return $this->view('mail.en.partner-id-rewoke-parent')->subject('Partner ID rewoked report from PupilPay');
    }
}
