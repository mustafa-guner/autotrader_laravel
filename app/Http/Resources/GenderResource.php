<?php

namespace App\Http\Resources;

use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Gender
 */
class GenderResource extends JsonResource
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
            'definition' => $this->definition,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
