<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\FeedbackSubmitted;
use App\Models\FeedbackType;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    public function test_it_stores_feedback()
    {
        Event::fake();
        /**
         * @var User $user
         * @var FeedbackType $feedbackType
         */
        $user = User::factory()->create();
        $feedbackType = FeedbackType::factory()->create();

        $this->actingAs($user)
            ->post(route('feedbacks.store'), [
                'feedback_type_id' => $feedbackType->id,
                'comment' => 'Test Description',
            ])->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('feedbacks', [
            'feedback_type_id' => $feedbackType->id,
            'comment' => 'Test Description',
            'user_id' => $user->id,
        ]);

        Event::assertDispatched(FeedbackSubmitted::class, function ($event) use ($user) {
            return $event->feedback->user_id === $user->id;
        });
    }
}
