<?php

namespace App\Http\Controllers;

use App\Constants\TransactionTypeConstants;
use App\Events\NotificationCreated;
use App\Exceptions\NotFoundException;
use App\Http\Requests\DepositRequest;
use App\Models\NotificationUser;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\UserBalanceHistory;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
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

            if (isset($fields['payment_method_id'])) {
                $payment_method = PaymentMethod::where('id', $fields['payment_method_id'])
                    ->where('user_id', $user->id)
                    ->first();
                if (!$payment_method) {
                    throw new NotFoundException('Payment method not found');
                }
                $userBalanceHistory->payment_method_id = $payment_method->id;
            } else {
                $card_number = $fields['card_number'];
                $payment_method = PaymentMethod::where('card_number', $card_number)
                    ->where('user_id', $user->id)
                    ->first();
                if (!$payment_method) {
                    $payment_method = PaymentMethod::create([
                        'user_id' => $user->id,
                        'card_number' => $card_number,
                        'card_holder' => $fields['card_holder'],
                        'expiration_date' => $fields['expiration_date'],
                        'cvv' => $fields['cvv'],
                    ]);
                    Log::info('User with ID ' . $user->id . ' has added new payment method with card number ' . $card_number);
                    $userBalanceHistory->payment_method_id = $payment_method->id;
                }
            }
            $userBalanceHistory->save();
            //create notification and fire the event
            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => trans('balance.deposit_success'),
                'is_read' => false
            ]);

            $data = [
                'balance' => $user->userBalance->balance,
            ];

            DB::commit();
            broadcast(new NotificationCreated($notification,$data))->toOthers();
            Log::info('User has deposited ' . $fields['amount'] . ' to his balance');
            return ResponseService::success(null, trans('balance.deposit_success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT DEPOSITED. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
