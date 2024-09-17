<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed $user_id
 * @property mixed $feedback_type_id
 * @property mixed $comment
 * @property mixed $created_at
 * @property mixed $updated_at
 *
 * @property User $user
 * @property FeedbackType $feedbackType
 */
class Feedback extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'feedback_type_id',
        'comment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feedbackType(): BelongsTo
    {
        return $this->belongsTo(FeedbackType::class, 'feedback_type_id');
    }
}
