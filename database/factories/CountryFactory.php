<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->country,
            'iso_code' => $this->faker->countryCode,
            'calling_code' => $this->faker->randomNumber(2),
            'flag' => $this->faker->imageUrl(640, 480, 'flag'),
        ];
    }
}
