<?php

namespace Database\Seeders;

use App\Models\PartnerId;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lukaParent = User::where('email', 'jackrestlertesting@gmail.com')->first();
        $lukaParentStudent = Student::where('user_id', $lukaParent->id)->first();
        $parent_merchant = PartnerId::where('user_id', $lukaParent->id)->get();
        foreach ($parent_merchant as $parentMerchantId) {
            Transaction::factory(60)->create([
                'user_id' => $lukaParent->id,
                'student_id' => $lukaParentStudent->id,
                'merchant_id' => $parentMerchantId->merchant_id,
            ]);
        }

        $nikolozParent = User::where('email', 'nikolozlomtadze0@gmail.com')->first();
        $nikolozParentStudent = Student::where('user_id', $nikolozParent->id)->first();
        $parent_merchant = PartnerId::where('user_id', $nikolozParent->id)->get();
        foreach ($parent_merchant as $parentMerchantId) {
            Transaction::factory(60)->create([
                'user_id' => $nikolozParent->id,
                'student_id' => $nikolozParentStudent->id,
                'merchant_id' => $parentMerchantId->merchant_id,
            ]);
        }

        $leventeParent = User::where('email', 'kazo.levente@gmail.com')->first();
        $leventeParentStudent = Student::where('user_id', $leventeParent->id)->first();
        $parent_merchant = PartnerId::where('user_id', $leventeParent->id)->get();
        foreach ($parent_merchant as $parentMerchantId) {
            Transaction::factory(60)->create([
                'user_id' => $leventeParent->id,
                'student_id' => $leventeParentStudent->id,
                'merchant_id' => $parentMerchantId->merchant_id,
            ]);
        }
    }
}
