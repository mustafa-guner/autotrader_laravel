<?php

namespace App\Jobs;

use App\Mail\ForgotPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordJob implements ShouldQueue
{
    use Queueable;
    protected PasswordResetToken $password_reset_token;

    /**
     * Create a new job instance.
     */
    public function __construct(PasswordResetToken $password_reset_token)
    {
        $this->password_reset_token = $password_reset_token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->password_reset_token->email)->send(new ForgotPasswordMail($this->password_reset_token));
    }
}
