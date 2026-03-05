<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role_id',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the products created by the user (as maker).
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'maker_id');
    }

    /**
     * Get the orders made by the user (as buyer).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /**
     * Get the reports submitted by the user.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_by');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the credit associated with the user.
     */
    public function credit()
    {
        return $this->hasOne(Credit::class);
    }

    /**
     * Get the credit transactions sent by the user.
     */
    public function creditTransactionsSent()
    {
        return $this->hasMany(CreditTransaction::class, 'from_user_id');
    }

    /**
     * Get the credit transactions received by the user.
     */
    public function creditTransactionsReceived()
    {
        return $this->hasMany(CreditTransaction::class, 'to_user_id');
    }
}
