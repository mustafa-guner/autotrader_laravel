<?php

namespace App\Policies;

use App\Models\User;

class BankAccountPolicy
{
    /**
     * Determine if the user can create a bank account.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Check if the user has fewer than 3 bank accounts
        return $user->bankAccounts()->count() < 3;
    }

    /**
     * Determine if the user can have more than one active account.
     *
     * @param User $user
     * @param  array  $attributes
     * @return bool
     */
    public function canSetActiveAccount(User $user, array $attributes): bool
    {
        // Check if the user is trying to set another account as active
        return !($attributes['is_active'] ?? false) || !$user->bankAccounts()->where('is_active', true)->exists();
    }
}
