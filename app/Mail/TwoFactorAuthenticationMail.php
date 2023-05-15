<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorAuthenticationMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(private int $code, private string $name, private string $browser, private string $device, private string $year, private string $language)
    {
    }

    public function build()
    {
        if ($this->language === 'hu') {
            return $this->view('mail.hu.two-factor-auth', ['code' => $this->code, 'name' => $this->name, 'browser' => $this->browser, 'device' => $this->device, 'year' => $this->year]);
        }

        return $this->view('mail.en.two-factor-auth', ['code' => $this->code, 'name' => $this->name, 'browser' => $this->browser, 'device' => $this->device, 'year' => $this->year]);
    }
}
