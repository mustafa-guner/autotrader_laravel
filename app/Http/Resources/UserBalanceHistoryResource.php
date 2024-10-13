<?php

namespace App\Http\Resources;

use App\Models\UserBalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserBalanceHistory
 */
class UserBalanceHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'balance' => $this->userBalance,
            'transaction_type' => $this->transactionType,
            'bank_account' => $this->bankAccount,
            'created_at' => $this->created_at,
        ];
    }
}
