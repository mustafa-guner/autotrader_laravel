<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SaveBankRequest;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BankController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $banks = Bank::orderBy('name')->get();
        return BankResource::collection($banks);
    }

    public function store(SaveBankRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $bank = Bank::create($validated_fields);
            DB::commit();
            Log::info('Bank with the ID ' . $bank->id . ' has been created by ' . auth()->user()->id);
            return ResponseService::success($bank, trans('commons.success'),Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating bank: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    /**
     * @param SaveBankRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(SaveBankRequest $request, $id): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            $bank = Bank::find($id);
            if (!$bank) {
                throw new NotFoundException();
            }
            DB::beginTransaction();
            $bank = $bank->update($validated_fields);
            DB::commit();
            Log::info('Bank with the ID ' . $bank->id . ' has been updated by ' . auth()->user()->id);
            return ResponseService::success($bank, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating bank: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $bank = Bank::find($id);
            if (!$bank) {
                throw new NotFoundException();
            }
            DB::beginTransaction();
            $bank->delete();
            DB::commit();
            Log::info('Bank with the ID ' . $bank->id . ' has been deleted by ' . auth()->user()->id);
            return ResponseService::success(null, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting bank: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
