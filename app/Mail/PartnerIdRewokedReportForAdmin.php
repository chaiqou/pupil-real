<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerIdRewokedReportForAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $user)
    {
    }

    public function build()
    {
        return $this->view('mail.partner-id-rewoke-admin')->subject('Partner ID rewoked report from PupilPay');
    }
}
