<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $bank_id
 * @property int $user_id
 * @property string $account_number
 * @property string $balance
 * @property string $currency
 */
class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'user_id',
        'account_number',
        'balance',
        'currency',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
