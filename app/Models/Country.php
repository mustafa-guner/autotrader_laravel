<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $iso_code
 * @property mixed $flag
 * @property mixed $calling_code
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso_code',
        'calling_code',
        'flag'
    ];
}
