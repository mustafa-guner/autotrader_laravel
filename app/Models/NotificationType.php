<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

/**
 * @property mixed $id
 * @property string $title
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class NotificationType extends Model
{
    use HasFactory;

    protected $table = 'notification_types';

    protected $fillable = [
        'title',
    ];
}
