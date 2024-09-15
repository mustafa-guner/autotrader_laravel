<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\UserBalance;

class CreateUserBalance
{
    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event): void
    {
        $userBalance = new UserBalance();
        $userBalance->user_id = $event->user->id;
        $userBalance->save();
    }
}
