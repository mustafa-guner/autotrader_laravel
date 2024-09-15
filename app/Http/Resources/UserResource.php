<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'full_name' => $this->full_name,
            'dob' => $this->dob,
            'country' => $this->country,
            'gender' => $this->gender,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'is_virtual_account' => $this->is_virtual_account,
            'created_at' => $this->created_at,
            'email_verified_at' => $this->email_verified_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
