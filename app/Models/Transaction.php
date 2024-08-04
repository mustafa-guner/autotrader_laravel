<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed description
 * @property mixed transaction_type_id
 * @property mixed transaction_status_id
 * @property mixed user_id
 * @property mixed amount
 * @property mixed currency
 * @property mixed transaction_by
 * @property mixed created_at
 * @property mixed updated_at
 *
 * @property TransactionType transactionType
 * @property TransactionStatus transactionStatus
 * @property User transactionBy
 * @property User user
 *
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'transaction_type_id',
        'transaction_status_id',
        'user_id',
        'amount',
        'currency',
        'transaction_by'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }

    public function transactionStatus(): BelongsTo
    {
        return $this->belongsTo(TransactionStatus::class, 'transaction_status_id');
    }

    public function transactionBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transaction_by');
    }
}
