<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $notification_id
 * @property mixed $is_read
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 *
 * @property Notification $notification
 * @property User $user
 */
class NotificationUser extends Model
{
    use HasFactory;

    protected $table = 'notification_user';

    protected $fillable = [
        'user_id',
        'notification_id',
        'is_read'
    ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
