<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\VerifyPhoneRequest;
use App\Models\UserPhone;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyPhoneController extends Controller
{
    public function __invoke(VerifyPhoneRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            $phone = UserPhone::where('verification_code', $validated_fields['verification_code'])
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$phone) {
                throw new NotFoundException('Phone not found');
            }

            DB::beginTransaction();
            $phone->is_verified = true;
            $phone->verified_at = now();
            $phone->verification_code = null;
            $phone->save();
            DB::commit();
            Log::info('Phone with the ID ' . $phone->id . ' has been verified by ' . auth()->user()->id);
            return ResponseService::success($phone, trans('commons.success'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error verifying phone: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
