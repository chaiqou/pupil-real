<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(private string $token)
	{
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(ForgotPasswordRequest $request)
	{
		$action_link = route('password.reset', ['token' => $this->token]);
		return $this->view('mail/email-forgot', ['action_link' => $action_link, 'body' => 'Check your password reset link']);
	}
}
