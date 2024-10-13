<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\PaymentMethod;
use App\Models\TransactionType;
use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserBalanceHistory>
 */
class UserBalanceHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_balance_id' => UserBalance::factory(),
            'amount' => $this->faker->randomNumber(2),
            'currency' => 'USD',
            'bank_account_id' => BankAccount::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'transaction_type_id' => TransactionType::factory()
        ];
    }
}
