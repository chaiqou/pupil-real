<?php

namespace App\Console\Commands;

use App\Mail\UserPartnerIdReportMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserToBillingoHealthCheck extends Command
{
    protected $signature = 'portal:user-partnerid-data-check';

    protected $description = 'Check if there is any user who is missing partnerId which is important';

    public function handle(): void
    {
        $users = User::with('partnerId')->get();

        foreach ($users as $user) {
            if (! isset($user->partnerId)) {
                Mail::to('info@pupilpay.hu')->send(new UserPartnerIdReportMail($user));
            }
        }
    }
}
