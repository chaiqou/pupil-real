<?php

namespace Database\Factories;

use App\Models\PartnerId;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //        $lukaParent = User::where('email', 'jackrestlertesting@gmail.com')->first();
        //        $lukaParentStudent = Student::where('user_id', $lukaParent->id)->first();
        //        $parent_merchant = PartnerId::where('user_id', $lukaParent->id)->first();
        $current_month_dates = $this->get_dates_until_end_of_month_for_transaction(date('Y-m-01'));
        $previous_month_dates = $this->get_dates_until_end_of_month_for_transaction(date('Y-m-01', strtotime('-1 month')));
        $random_dates = array_merge(array_diff($current_month_dates, array_rand($current_month_dates, 3)), $previous_month_dates);

        $date = $random_dates[$this->faker->numberBetween(0, count($random_dates) - 1)];

        return [
            'user_id' => '',
            'student_id' => '',
            'merchant_id' => '',
            'transaction_identifier' => 'here_should_be_some_hash',
            'transaction_date' => $date,
            'transaction_amount' => rand(1, 500),
            'transaction_type' => 'payment',
            'comments' => json_encode([
                'comment' => 'Placed lunch order on '.$date,
                'comment_history' => [],
            ]),
            'history' => json_encode([
                'history' => [],
            ]),
            'payment_method' => 'stripe',
            'billing_items' => json_encode([
                'name' => 'Test lunch',
                'unit_price' => 'pricePeriod',
                'unit_price_type' => 'gross',
                'quantity' => 1,
                'unit' => 'db',
                'vat' => '27%',
            ]),
            'billing_provider' => 'none',
            'billing_comment' => json_encode([
                'comment' => 'hardcoded billing comment',
            ]),
        ];
    }

    protected function get_dates_until_end_of_month_for_transaction($start_date)
    {
        $current_date = date('Y-m-d');
        $last_day = date('t', strtotime($start_date));
        $dates = [];
        for ($i = 0; $i < $last_day; $i++) {
            $date = date('Y-m-d', strtotime($start_date." + $i day"));
            if ($date <= $current_date) {
                $dates[] = $date;
            }
        }

        return $dates;
    }
}
