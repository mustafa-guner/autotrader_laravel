<?php

namespace App\Http\Controllers;

use App\Constants\TransactionTypeConstants;
use App\Events\NotificationCreated;
use App\Http\Requests\WithdrawRequest;
use App\Models\NotificationUser;
use App\Models\User;
use App\Models\UserBalanceHistory;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public function update(WithdrawRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();

            /**
             * @var User $user
             */
            $user = auth()->user();
            DB::beginTransaction();
            $user->userBalance->update([
                'balance' => $user->userBalance->balance - $fields['amount']
            ]);


            //CREATE BALANCE HISTORY
            UserBalanceHistory::create([
                'amount' => $fields['amount'],
                'user_balance_id' => $user->userBalance->id,
                'currency' => $user->userBalance->currency,
                'transaction_type_id' => TransactionTypeConstants::WITHDRAWAL,
                'bank_account_id' => $fields['bank_account_id']
            ]);


            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => trans('balance.withdraw_success'),
                'is_read' => false
            ]);

            $data = [
                'balance' => $user->userBalance->balance,
            ];

            DB::commit();

            broadcast(new NotificationCreated($notification,$data))->toOthers();
            Log::info('User has withdrawn ' . $fields['amount'] . ' from his balance');
            return ResponseService::success(null, trans('balance.withdraw_success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT WITHDRAWN. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
