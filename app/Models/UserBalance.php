<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $balance
 * @property string $currency
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class UserBalance extends Model
{
    use HasFactory;

    protected $table = 'user_balances';

    protected $fillable = [
        'user_id',
        'balance',
        'currency'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
