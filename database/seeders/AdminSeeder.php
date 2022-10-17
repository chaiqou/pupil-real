<?php

namespace Database\Seeders;

use App\Models\Invite;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        School::create(['id' => 1]);

        User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
        ]);
	}
}
