<?php

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Bank',
            'description' => $this->faker->sentence,
            'logo' => $this->faker->imageUrl(),
            'swift_code' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'website' => $this->faker->url,
        ];
    }

    public function deactivated(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
