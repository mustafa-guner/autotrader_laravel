<?php

namespace App\Listeners\UserRegistered;

use App\Events\UserRegistered;
use App\Notifications\VerifyEmail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendVerificationEmail
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
    public function handle(UserRegistered $event): void
    {
        try {
            $event->user->notify(new VerifyEmail($event->user));
        } catch (Exception $e) {
            Log::error('Error while sending verification email: ' . $e->getMessage());
        }
    }
}
