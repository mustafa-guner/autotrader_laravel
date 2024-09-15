<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BankAccount>
 */
class BankAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bank_id' => Bank::factory(),
            'user_id' => User::factory(),
            'account_number' => $this->faker->bankAccountNumber
        ];
    }
}
