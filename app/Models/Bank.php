<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property string $swift_code
 * @property bool $is_active
 * @property string $website
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Bank extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'logo',
        'swift_code',
        'is_active',
        'website',
    ];
}
