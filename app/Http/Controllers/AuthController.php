<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function index(): UserResource
    {
        $user = auth()->user();
        return UserResource::make($user);
    }

    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            if (!auth()->attempt($validated_fields)) {
                Log::error('Invalid credentials provided.');
                return ResponseService::fail(trans('auth.invalid_credentials'), Response::HTTP_UNAUTHORIZED);
            }
            $user = auth()->user();

            if (!$user->hasVerifiedEmail()) {
                Log::error('Log in failed.User with email ' . auth()->user()->email . ' has not verified their email.');
                return ResponseService::fail(trans('auth.email_not_verified'), Response::HTTP_UNAUTHORIZED);
            }

            if (!$user->is_active) {
                Log::error('Log in failed.User with email ' . auth()->user()->email . ' is not active.');
                return ResponseService::fail(trans('auth.account_not_active'), Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            Log::info('User with email ' . $user->email . ' has logged in successfully.');

            return ResponseService::success(['token' => $token], trans('commons.success'));
        } catch (Exception $e) {
            Log::error('Error logging in: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function destroy(): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
            Log::info('User with email ' . auth()->user()->email . ' has logged out successfully.');
            return ResponseService::success(null, trans('auth.logged_out'));
        } catch (Exception $e) {
            Log::error('Error logging out: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
