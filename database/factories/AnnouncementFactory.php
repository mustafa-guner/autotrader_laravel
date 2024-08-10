<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'thumbnail' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime,
            'created_by' => UserFactory::make(),
            'updated_by' => UserFactory::make(),
            'deleted_by' => UserFactory::make(),
            'published_by' => UserFactory::make(),
        ];
    }
}
