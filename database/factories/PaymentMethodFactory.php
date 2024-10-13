<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentMethod>
 */
class PaymentMethodFactory extends Factory
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
            'card_number' => $this->faker->creditCardNumber,
            'card_holder' => $this->faker->name,
            'expiration_date' => $this->faker->creditCardExpirationDate,
            'is_default' => $this->faker->boolean,
            'cvv' => $this->faker->randomNumber(3),
        ];
    }
}
