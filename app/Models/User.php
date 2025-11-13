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
        'name',
        'email',
        'password',
        'role',
        'status',
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
        ];
    }

    /**
     * Get the seller profile associated with the user.
     */
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * Get the products associated with the seller.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders as buyer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the orders as seller.
     */
    public function sales()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is seller.
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    /**
     * Check if user is buyer.
     */
    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
