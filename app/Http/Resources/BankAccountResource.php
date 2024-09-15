<?php

namespace App\Http\Resources;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BankAccount
 */
class BankAccountResource extends JsonResource
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
            'bank' => BankResource::make($this->bank),
            'account_number' => $this->account_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
