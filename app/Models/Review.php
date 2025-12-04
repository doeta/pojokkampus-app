<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /**
     * SRS-MartPlace-06: Review dapat diberikan oleh pengunjung tanpa login
     * Data yang disimpan: nama, nomor HP, email, rating (1-5), komentar
     */
    protected $fillable = [
        'product_id',
        'name',
        'phone',
        'email',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
