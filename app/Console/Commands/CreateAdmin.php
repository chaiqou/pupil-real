<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'portal:create-admin';

    protected $description = 'Creates a new admin';

    public function handle()
    {
        $name = $this->ask('What should the admin username be?');
        $email = $this->ask('What should the admin email be?');
        $password = $this->secret('What should the password be? (The input is hidden)');
        $this->info('Creating the admin...');

        if (User::where('email', $email)->first()) {
            $this->error('Admin already exists!');

            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'finished_onboarding' => 1,
        ])->assignRole('admin', '2fa');

        $this->info('Admin created successfully.');
    }
}
