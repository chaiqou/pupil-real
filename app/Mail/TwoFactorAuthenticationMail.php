<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorAuthenticationMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(private int $code, private string $name, private string $browser, private string $device, private string $year)
	{
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('mail.two-factor-auth', ['code' => $this->code, 'name' => $this->name, 'browser' => $this->browser, 'device' => $this->device, 'year' => $this->year]);
	}
}
