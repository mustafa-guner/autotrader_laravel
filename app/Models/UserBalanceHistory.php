<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $id
 * @property mixed user_balance_id
 * @property mixed amount
 * @property mixed currency
 * @property mixed bank_account_id
 * @property mixed transaction_type_id
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 *
 * @property UserBalance userBalance
 * @property BankAccount $bankAccount
 * @property TransactionType transactionType
 */
class UserBalanceHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_balance_history';
    protected $fillable = [
        'user_balance_id',
        'amount',
        'currency',
        'bank_account_id',
        'transaction_type_id'
    ];

    public function userBalance(): BelongsTo
    {
        return $this->belongsTo(UserBalance::class, 'user_balance_id');
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id')->with('bank');
    }

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }


}
