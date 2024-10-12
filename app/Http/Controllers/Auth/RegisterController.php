<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $validated_fields['password'] = Hash::make($validated_fields['password']);
            $user = User::create($validated_fields);
            DB::commit();
            event(new UserRegistered($user));
            Log::info('User with email ' . $user->email . ' has been registered successfully.');
            return ResponseService::success(null, trans('auth.account_created_please_verify_your_email'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error while registering user: ' . $e->getMessage());
            return ResponseService::fail(trans('error.auth.account_creation_failed'));
        }
    }
}
