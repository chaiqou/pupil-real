<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dash:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('What should the username be?');
        $email = $this->ask('What should the email be?');
        $password = $this->secret('What should the password be? (The input is hidden)');
        $this->info('Creating the user...');

        if (User::where('email', $email)->first()) {
            $this->error('User already exists!');

            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ])->assignRole('admin');

        $this->info('User created successfully.');
    }
}
