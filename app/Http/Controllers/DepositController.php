<?php

namespace App\Http\Controllers;

use App\Constants\TransactionStatusConstants;
use App\Constants\TransactionTypeConstants;
use App\Http\Requests\DepositRequest;
use App\Models\User;
use App\Models\UserBalanceHistory;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    public function update(DepositRequest $request): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $fields = $request->validated();
            $user = auth()->user();
            DB::beginTransaction();
            $user->userBalance->update([
                'balance' => $user->userBalance->balance + $fields['amount']
            ]);

            UserBalanceHistory::create([
                'amount' => $fields['amount'],
                'user_balance_id' => $user->userBalance->id,
                'currency' => $user->userBalance->currency,
                'transaction_type_id' => TransactionTypeConstants::DEPOSIT,
                'bank_account_id' => $fields['bank_account_id']
            ]);

            DB::commit();
            Log::info('User has deposited ' . $fields['amount'] . ' to his balance');
            return ResponseService::success(null, trans('balance.deposit_success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT DEPOSITED. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
