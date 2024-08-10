<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $phone_type_id
 * @property mixed $phone_number
 * @property mixed $is_verified
 * @property mixed $verification_code
 * @property mixed $verified_at
 *
 * @property User $user
 * @property PhoneType $phoneType
 */
class UserPhone extends Model
{
    use HasFactory;

    protected $table = 'user_phone';

    protected $fillable = [
        'user_id',
        'phone_type_id',
        'phone_number',
        'is_verified',
        'verification_code',
        'verified_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function phoneType(): BelongsTo
    {
        return $this->belongsTo(PhoneType::class, 'phone_type_id');
    }
}
