<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserShare
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int $quantity
 * @property int price
 * @property mixed symbol
 * @property int bought_by
 * @property int sold_by
 * @property string exchange
 * @property string action_type
 * @property string created_at
 *
 * @property User user
 */
class UserShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quantity',
        'price',
        'name',
        'symbol',
        'bought_by',
        'sold_by',
        'action_type',
        'exchange',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
