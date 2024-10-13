<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $symbol
 * @property mixed $exchange
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'exchange',
    ];

}
