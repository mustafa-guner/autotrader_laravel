<?php

namespace App\Listeners\UserRegistered;

use App\Constants\UserBalanceConstants;
use App\Events\UserRegistered;
use App\Models\NotificationUser;
use App\Models\UserBalance;
use App\Notifications\BalanceNotification;
use Exception;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Events\NotificationCreated;

class CreateUserBalance
{
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        try {
            DB::beginTransaction();
            $userBalance = UserBalance::create([
                'user_id' => $user->id,
                'balance' => UserBalanceConstants::WELCOME_BONUS,
                'currency' => UserBalanceConstants::DEFAULT_CURRENCY
            ]);

            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => trans('balance.default_notification_message', [
                    'amount' => $userBalance->balance,
                    'currency' => $userBalance->currency
                ]),
                'is_read' => false
            ]);

            DB::commit();

            // Broadcast the notification
            broadcast(new NotificationCreated($notification))->toOthers();

            Log::info('User balance with ID ' . $userBalance->id . ' is CREATED for User ID: ' . $userBalance->user_id);
            $user->notify(new BalanceNotification($userBalance));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT CREATED. Error: ' . $e->getMessage());
        }
    }
}

