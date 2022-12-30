<?php

namespace App\Console\Commands;

use App\Mail\UserPartnerIdReportMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserToBillingoHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user-partner-id-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
          $users = User::with('partnerId')->get();

          foreach($users as $user)
          {
              if(!isset($user->partnerId)) {
                  Mail::to("info@pupilpay.hu")->send(new UserPartnerIdReportMail($user));
              };
          }
    }
}
