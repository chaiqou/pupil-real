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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private string $token, private string $name, private string $browser, private string $device)
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
        $action_link = route('password.reset', ['token' => $this->token]);

        return $this->view('mail/email-forgot', ['action_link' => $action_link, 'body' => 'Check your password reset link', 'name' => $this->name, 'browser' => $this->browser, 'device' => $this->device])->subject('Password Reset for PupilPay');
    }
}
