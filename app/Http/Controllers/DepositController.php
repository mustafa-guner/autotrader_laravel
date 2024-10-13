<?php

namespace App\Http\Controllers;

use App\Constants\TransactionStatusConstants;
use App\Constants\TransactionTypeConstants;
use App\Http\Requests\DepositRequest;
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
    public function update(DepositRequest $request): JsonResponse
    {
        $fields = $request->validated();
        /**
         * @var User $user
         */
        $user = auth()->user();

        try {
            DB::beginTransaction();

            $this->updateUserBalance($user, $fields['amount']);
            $paymentMethod = $this->getOrCreatePaymentMethod($user, $fields);
            $this->logUserBalanceHistory($user, $fields['amount'], $paymentMethod);

            DB::commit();
            Log::info('User has deposited ' . $fields['amount'] . ' to his balance');

            return ResponseService::success(null, trans('balance.deposit_success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT DEPOSITED. Error: ' . $e->getMessage());

            return ResponseService::fail(trans('commons.fail'));
        }
    }

    private function updateUserBalance(User $user, float $amount): void
    {
        $user->userBalance->increment('balance', $amount);
    }

    private function getOrCreatePaymentMethod(User $user, array $fields): PaymentMethod
    {
        return PaymentMethod::firstOrCreate(
            ['card_number' => $fields['card_number']],
            [
                'user_id' => $user->id,
                'card_holder' => $fields['card_holder'],
                'expiration_date' => $fields['expiration_date'],
                'cvv' => $fields['cvv'],
            ]
        );
    }

    private function logUserBalanceHistory(User $user, float $amount, PaymentMethod $paymentMethod): void
    {
        UserBalanceHistory::create([
            'amount' => $amount,
            'user_balance_id' => $user->userBalance->id,
            'currency' => $user->userBalance->currency,
            'transaction_type_id' => TransactionTypeConstants::DEPOSIT,
            'payment_method_id' => $paymentMethod->id,
        ]);
    }
}
