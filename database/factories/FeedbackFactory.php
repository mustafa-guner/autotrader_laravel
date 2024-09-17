<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\FeedbackType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feedback>
 */
class FeedbackFactory extends Factory
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
            'feedback_type_id' => FeedbackType::factory(),
            'comment' => $this->faker->sentence,
        ];
    }
}
