<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            $token = $validated_fields['token'];
            $password = $request->get('password');

            $user = User::where('email', $email)->first();
            $password_reset_token = $user->passwordResetToken;

            //Check if the user exists
            if (!$user) {
                throw new NotFoundException('User not found');
            }

            //Check if the token is expired
            if ($password_reset_token->created_at->addMinutes(5) < now()) {
                return ResponseService::fail(__('validation.auth.token_expired'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            //Check if the token is valid
            if ($password_reset_token->token != $token) {
                return ResponseService::fail(__('validation.auth.token_invalid'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();
            $user->update(['password' => bcrypt($password)]);
            $password_reset_token->delete();
            DB::commit();
            Log::info('Password reset for user with email: ' . $email);
            return ResponseService::success(null, __('validation.auth.password_reset_success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Password reset error: ' . $e->getMessage());
            return ResponseService::fail(__('validation.error.default'));
        }
    }
}
