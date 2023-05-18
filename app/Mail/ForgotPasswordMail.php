<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(private string $token, private string $name, private string $browser, private string $device, private string $language)
    {
        //
    }

    public function build()
    {
        if ($this->language === 'hu') {
            $action_link = route('password.reset', ['token' => $this->token]);

            return $this->view('mail/hu/email-forgot', ['action_link' => $action_link, 'body' => 'Ellenőrizze a jelszó visszaálítási linkjét', 'name' => $this->name, 'browser' => $this->browser, 'device' => $this->device])->subject('Jelszó visszaállítása a PupilPay-hez');
        }
        $action_link = route('password.reset', ['token' => $this->token]);

        return $this->view('mail/en/email-forgot', ['action_link' => $action_link, 'body' => 'Check your password reset link', 'name' => $this->name, 'browser' => $this->browser, 'device' => $this->device])->subject('Password Reset for PupilPay');
    }
}
