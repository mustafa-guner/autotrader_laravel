<?php

namespace App\Http\Resources;

use App\Models\UserShare;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserShare
 */
class ShareResource extends JsonResource
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
            'quantity' => $this->quantity,
            'action_type' => $this->action_type,
            'bought_by' => $this->bought_by,
            'sold_by' => $this->sold_by,
        ];
    }
}
