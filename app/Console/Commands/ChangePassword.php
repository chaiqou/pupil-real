<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ChangePassword extends Command
{
    protected $signature = 'user:change-password';

    protected $description = 'Change password of an already registered user';

    public function handle()
    {
        $email = $this->ask('What is the email of the user?');
        $password = $this->secret('What should the password be? (The input is hidden)');
        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error('User not found!');

            return 1;
        }
        $user->password = bcrypt($password);
        $user->save();
        $this->info('Password changed successfully.');
    }
}
