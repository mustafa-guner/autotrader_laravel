<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $bank_id
 * @property int $user_id
 * @property string $account_number
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bank $bank
 * @property User $user
 * @property UserBalanceHistory $balanceHistory
 */
class BankAccount extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'bank_id',
        'user_id',
        'account_number',
    ];

    public function balanceHistory():BelongsToMany
    {
        return $this->belongsToMany(UserBalanceHistory::class, 'bank_account_id');
    }
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
