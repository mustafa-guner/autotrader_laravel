<?php

namespace App\Events;

use App\Models\Feedback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeedbackSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Feedback $feedback;

    /**
     * Create a new event instance.
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }
}
