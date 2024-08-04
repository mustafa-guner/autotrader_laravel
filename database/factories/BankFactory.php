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
            'name' => ['en' => $this->faker->name, 'ar' => $this->faker->name],
            'description' => ['en' => $this->faker->sentence, 'ar' => $this->faker->sentence],
            'logo' => $this->faker->imageUrl(),
            'code' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'website' => $this->faker->url,
        ];
    }
}
