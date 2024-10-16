<?php

namespace App\Listeners\FeedbackSubmitted;

use App\Events\FeedbackSubmitted;
use App\Mail\FeedbackMail;
use Illuminate\Support\Facades\Mail;

class SendFeedbackNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FeedbackSubmitted $event): void
    {
        $responsible_people = config('feedback.feedback_responsible_people');
        foreach ($responsible_people as $responsible_person) {
            Mail::to($responsible_person)
                ->send(new FeedbackMail($event->feedback));
        }
    }
}
