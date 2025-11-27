<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'brand',
        'description',
        'price',
        'weight',
        'condition',
        'stock',
        'min_order',
        'image',
        'images',
        'status',
        'views',
        'sold',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'views' => 'integer',
        'sold' => 'integer',
        'stock' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Alias for user (seller)
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function decrementStock(int $quantity): void
    {
        $this->decrement('stock', $quantity);
        $this->increment('sold', $quantity);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
