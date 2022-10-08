<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ChangePassword extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:password';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change password of an already registered user';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$email = $this->ask('What is the email of the user?');
		$password = $this->secret('What should the password be? (The input is hidden)');
		$user = User::where('email', $email)->first();
		if (!$user)
		{
			$this->error('User not found!');
			return 1;
		}
		$user->password = bcrypt($password);
		$user->save();
		$this->info('Password changed successfully.');
	}
}
