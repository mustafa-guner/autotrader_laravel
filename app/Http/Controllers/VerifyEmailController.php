<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    public function __invoke(VerifyEmailRequest $request): View
    {
        try {
            $validated_fields = $request->validated();
            $user = User::find($validated_fields['user_id']);
            if (!$user) {
                throw new NotFoundException();
            }
            if ($user->hasVerifiedEmail()) {
                Log::error('Email already verified.');
            }
            $user->markEmailAsVerified();
            Log::info('Email verified successfully.');
            return view('emails.email-verified-success');
        } catch (Exception $e) {
            Log::error('Error verifying email: ' . $e->getMessage());
            return view('emails.email-verified-fail');
        }
    }
}
