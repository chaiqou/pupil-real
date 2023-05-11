<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPartnerIdReportMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public $user)
    {
        //
    }

    public function build()
    {
        return $this->view('mail.user-partner-id-report')->subject('PupilPay Report for user partner id data');
    }
}
