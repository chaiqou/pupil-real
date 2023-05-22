<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\SerializesModels;

class JobFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;

    public function __construct(JobFailed $event)
    {
        $this->event = $event;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Job Failed Mail',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'mail.job-failed',
        );
    }

    public function attachments()
    {
        return [];
    }
}
