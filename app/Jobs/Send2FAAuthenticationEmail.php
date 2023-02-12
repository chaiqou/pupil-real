<?php

namespace App\Jobs;

use App\Mail\TwoFactorAuthenticationMail;
use App\Models\User;
use App\Traits\BrowserNameAndDevice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Send2FAAuthenticationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BrowserNameAndDevice;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $code = random_int(100000, 999999);

        $this->user->update(['two_factor_token' => $code]);
        Mail::to($this->user->email)->send(new TwoFactorAuthenticationMail($code, $this->user->first_name, $this->getBrowserName(), $this->getDeviceName(), date('Y')));
    }
}
