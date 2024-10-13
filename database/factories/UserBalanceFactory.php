<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserBalance>
 */
class UserBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'balance' => $this->faker->randomFloat(2, 0, 1000),
            'currency' => $this->faker->currencyCode,
        ];
    }
}
