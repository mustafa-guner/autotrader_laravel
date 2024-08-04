<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Exception;

class UserTransactionController extends Controller
{
    public function index($user_id, $type_id, $status_id): AnonymousResourceCollection|JsonResponse
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                throw new NotFoundException();
            }

            $transactions = $user->transactions();

            if ($type_id) {
                $transactions->where('type_id', $type_id);
            }

            if ($status_id) {
                $transactions->where('status_id', $status_id);
            }

            $transactions = $transactions->paginate(10);

            return TransactionResource::collection($transactions);
        } catch (Exception $e) {
            Log::error('Error while fetching transactions: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function show($transaction_id): TransactionResource|JsonResponse
    {
        try {
            $transaction = Transaction::find($transaction_id);

            if (!$transaction) {
                throw new NotFoundException();
            }

            return TransactionResource::make($transaction);

        } catch (Exception $e) {
            Log::error('Error while fetching user: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

}
