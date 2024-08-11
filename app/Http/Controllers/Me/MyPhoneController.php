<?php

namespace App\Http\Controllers\Me;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveMyPhoneRequest;
use App\Http\Resources\PhoneResource;
use App\Models\UserPhone;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MyPhoneController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $phones = auth()->user()->phones;
        return PhoneResource::collection($phones);
    }

    public function store(SaveMyPhoneRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $phone = UserPhone::create($validated_fields);
            DB::commit();
            Log::info('Phone with the ID ' . $phone->id . ' has been created by ' . auth()->user()->id);
            return ResponseService::success($phone, trans('commons.success'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating phone: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function update(SaveMyPhoneRequest $request, $id): JsonResponse
    {
        try {
            $user_phone = UserPhone::find($id);
            if (!$user_phone) {
                throw new NotFoundException();
            }
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $user_phone->update($validated_fields);
            DB::commit();
            Log::info('Phone with the ID ' . $user_phone->id . ' has been updated by ' . auth()->user()->id);
            return ResponseService::success($user_phone, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating phone: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $user_phone = UserPhone::find($id);
            if (!$user_phone) {
                throw new NotFoundException();
            }
            DB::beginTransaction();
            $user_phone->deleted_by = auth()->user()->id;
            $user_phone->save();
            $user_phone->delete();
            DB::commit();
            Log::info('Phone with the ID ' . $user_phone->id . ' has been deleted by ' . auth()->user()->id);
            return ResponseService::fail(null, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting phone: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
