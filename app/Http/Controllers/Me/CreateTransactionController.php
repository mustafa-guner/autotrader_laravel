<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTransactionRequest;
use App\Models\Notification;
use App\Models\Transaction;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CreateTransactionController extends Controller
{
    public function __invoke(SaveTransactionRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $transaction = Transaction::create($validated_fields);
            DB::commit();
            $successfull_transaction = Notification::create([
                'title' => 'Transaction Successful',
                'content' => 'Your transaction with id ' . $transaction->id . ' has been saved successfully.',
                'type' => 'success'
            ]);
            Log::info('Transaction with id ' . $transaction->id . ' has been saved successfully for user_id ' . $transaction->user_id);
            return  ResponseService::success($transaction, trans('commons.success'),Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error while saving transaction: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
