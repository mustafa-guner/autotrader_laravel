<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed definition
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class TransactionStatus extends Model
{
    use HasFactory;

    protected $table = 'transaction_statuses';

    protected $fillable = ['definition'];
}
