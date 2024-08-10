<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property array $definition
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class TransactionType extends Model
{
    use HasFactory;

    protected $table = 'transaction_types';

    protected $fillable = [
        'definition'
    ];
}
