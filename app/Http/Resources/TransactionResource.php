<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Transaction
 */
class TransactionResource extends JsonResource
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
            'description' => $this->description,
            'transaction_type' => $this->transactionType,
            'transaction_status' => $this->transactionStatus,
            'user' => $this->user,
            'transaction_by' => $this->transactionBy,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
