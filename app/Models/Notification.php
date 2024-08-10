<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

/**
 * @property mixed $id
 * @property string $title
 * @property string $content
 * @property enum $type
 * @property mixed $thumbnail
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'content',
        'type',
        'thumbnail'
    ];
}
