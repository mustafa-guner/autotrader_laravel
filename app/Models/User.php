<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


/**
 * @property mixed id
 * @property mixed firstname
 * @property mixed lastname
 * @property mixed email
 * @property mixed $profile_image
 * @property mixed password
 * @property mixed country_id
 * @property mixed $gender_id
 * @property mixed is_active
 * @property mixed is_virtual_account
 * @property mixed email_verified_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $created_by
 * @property mixed $updated_by
 * @property mixed $deleted_by
 * @property mixed $deleted_at
 *
 * @property Country $country
 * @property Gender $gender
 * @property Transaction[] $transactions
 * @property NotificationUser[] $notifications
 * @property UserPhone[] $phones
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'profile_image',
        'country_id',
        'gender_id',
        'is_active',
        'is_virtual_account',
        'email_verified_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'is_virtual_account' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function passwordResetToken(): BelongsTo
    {
        return $this->belongsTo(PasswordResetToken::class, 'email', 'email');
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail($this));
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo('gender_id', Gender::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo('country_id', Country::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationUser::class, 'user_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(UserPhone::class, 'user_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo('created_by', User::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo('updated_by', User::class);
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo('deleted_by', User::class);
    }
}
