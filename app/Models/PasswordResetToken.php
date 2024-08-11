<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $token
 * @property mixed $email
 * @property mixed $created_at
 */
class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    protected $fillable = ['email', 'token', 'created_at'];
}
