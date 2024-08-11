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
    public function __invoke($id,$hash): View
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new NotFoundException();
            }
            if ($user->hasVerifiedEmail()) {
                Log::error('Email already verified.');
            }
            $user->markEmailAsVerified();
            Log::info('Email verified successfully.');
            return view('emails.email-verification')->with('is_success', true);
        } catch (Exception $e) {
            Log::error('Error verifying email: ' . $e->getMessage());
            return view('emails.email-verification')->with('is_success', false);
        }
    }
}
