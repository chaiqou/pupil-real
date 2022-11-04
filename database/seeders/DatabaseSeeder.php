<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
