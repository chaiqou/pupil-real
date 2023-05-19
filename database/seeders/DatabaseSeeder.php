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
//        $this->call(SchoolSeeder::class);
//        $this->call(AdminSeeder::class);
        $this->call(MerchantSeeder::class);
//        $this->call(LunchSeeder::class);
//        $this->call(ParentSeeder::class);
//        $this->call(StudentSeeder::class);
//        $this->call(TransactionSeeder::class);
    }
}
