<?php

namespace Database\Factories;

use App\Models\NotificationType;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NotificationUser>
 */
class NotificationUserFactory extends Factory
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
            'message' => $this->faker->sentence(),
            'is_read' => $this->faker->boolean(),
        ];
    }
}
