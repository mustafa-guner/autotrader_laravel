<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Jobs\ForgotPasswordJob;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class ForgotPasswordController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $email = $request->get('email');
            $user = User::where('email', $email)->first();
            if (!$user) {
                throw new NotFoundException('User not found');
            }
            $token = rand(100000, 999999);

            DB::beginTransaction();
            $password_reset_token = PasswordResetToken::create([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now()
            ]);
            DB::commit();
            dispatch(new ForgotPasswordJob($password_reset_token));
            Log::info('Password reset mail sent to: ' . $user->email);
            return ResponseService::success(null, __('common.password_reset_mail_sent'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Password reset link/token has not been send. Error: ' . $e->getMessage());
            return ResponseService::fail(__('validation.error.default'));
        }
    }
}
