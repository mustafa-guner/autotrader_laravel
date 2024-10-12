<?php

namespace App\Listeners\UserRegistered;

use App\Constants\UserBalanceConstants;
use App\Events\UserRegistered;
use App\Models\UserBalance;
use App\Notifications\BalanceNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateUserBalance
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        try {
            DB::beginTransaction();
            $user = $event->user;
            $userBalance = UserBalance::create(['user_id' => $user->id]);
            DB::commit();
            Log::info('User balance with ID ' . $userBalance->id . ' is created. User ID: ' . $userBalance->user_id);
            $user->notify(new BalanceNotification(UserBalanceConstants::WELCOME_BONUS, UserBalanceConstants::DEFAULT_CURRENCY));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is not created. Error: ' . $e->getMessage());
        }
    }
}
