<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __invoke(UserRegistrationRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $validated_fields['password'] = Hash::make($validated_fields['password']);
            $user = User::create($validated_fields);
            event(new UserRegistered($user));
            DB::commit();
            Log::info('User with email ' . $user->email . ' has been registered successfully.');
            return ResponseService::success(null, trans('user.account_created_please_verify_your_email'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error while registering user: ' . $e->getMessage());
            return ResponseService::fail(trans('error.user.account_creation_failed'));
        }
    }
}
