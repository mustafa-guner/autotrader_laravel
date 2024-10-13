<?php

namespace App\Http\Controllers;

use App\Constants\TransactionStatusConstants;
use App\Constants\TransactionTypeConstants;
use App\Exceptions\NotFoundException;
use App\Http\Requests\DepositRequest;
use App\Models\PaymentMethod;
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
    /**
     * @throws NotFoundException
     */
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

            $userBalanceHistory = new UserBalanceHistory();
            $userBalanceHistory->amount = $fields['amount'];
            $userBalanceHistory->user_balance_id = $user->userBalance->id;
            $userBalanceHistory->currency = $user->userBalance->currency;
            $userBalanceHistory->transaction_type_id = TransactionTypeConstants::DEPOSIT;

            if(isset($fields['payment_method_id'])) {
                $payment_method = PaymentMethod::where('id', $fields['payment_method_id'])->first();
                if(!$payment_method) {
                    throw new NotFoundException('Payment method not found');
                }
                $userBalanceHistory->payment_method_id = $payment_method->id;
            } else{
                $card_number = $fields['card_number'];
                $payment_method = PaymentMethod::where('card_number', $card_number)->first();
                if (!$payment_method) {
                    $payment_method = PaymentMethod::create([
                        'user_id' => $user->id,
                        'card_number' => $card_number,
                        'card_holder' => $fields['card_holder'],
                        'expiration_date' => $fields['expiration_date'],
                        'cvv' => $fields['cvv'],
                    ]);
                    $userBalanceHistory->payment_method_id = $payment_method->id;
                }
            }
            $userBalanceHistory->save();
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
