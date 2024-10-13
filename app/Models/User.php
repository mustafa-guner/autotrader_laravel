<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


/**
 * @property mixed id
 * @property mixed firstname
 * @property mixed lastname
 * @property mixed email
 * @property mixed $profile_image
 * @property mixed $dob
 * @property mixed password
 * @property mixed country_id
 * @property mixed $gender_id
 * @property mixed is_active
 * @property mixed is_virtual_account
 * @property mixed email_verified_at
 * @property mixed full_name
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $created_by
 * @property mixed $updated_by
 * @property mixed $deleted_by
 * @property mixed $deleted_at
 *
 * @property Country $country
 * @property Gender $gender
 * @property UserBalance $userBalance
 * @property Transaction[] $transactions
 * @property NotificationUser[] $notifications
 * @property BankAccount[] $bankAccounts
 * @property UserPhone[] $phones
 * @property UserBalanceHistory[] $userBalanceHistory
 * @property PaymentMethod[] $paymentMethods
 * @property UserShare[] $shares
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

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
        'dob',
        'country_id',
        'gender_id',
        'is_active',
        'is_virtual_account',
        'email_verified_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $appends = ['full_name'];

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

    public function getFullNameAttribute(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function passwordResetToken(): BelongsTo
    {
        return $this->belongsTo(PasswordResetToken::class, 'email', 'email');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_by');
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class, 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationUser::class, 'user_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(UserPhone::class, 'user_id');
    }

    public function userBalance(): HasOne
    {
        return $this->hasOne(UserBalance::class, 'user_id');
    }

    public function shares(): HasMany
    {
        return $this->hasMany(UserShare::class, 'user_id');
    }

    public function userBalanceHistory(): HasMany
    {
        return $this->userBalance->hasMany(UserBalanceHistory::class, 'user_balance_id');
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'user_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
