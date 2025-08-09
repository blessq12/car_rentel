<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'reviewer_id',
        'reviewed_id',
        'rating',
        'comment',
        'is_verified',
        'metadata',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'metadata' => 'array',
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'reviewer_id');
    }

    public function reviewed(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'reviewed_id');
    }

    // Получить название того, кто оставил отзыв
    public function getReviewerNameAttribute(): string
    {
        return $this->reviewer->name;
    }

    // Получить название того, о ком отзыв
    public function getReviewedNameAttribute(): string
    {
        // Проверяем, является ли reviewed владельцем автомобиля из сделки
        if ($this->deal && $this->deal->car) {
            return $this->deal->car->owner_name;
        }
        return $this->reviewed->name;
    }

    // Проверить, является ли reviewed таксопарком
    public function isReviewedTaxiCompany(): bool
    {
        if ($this->deal && $this->deal->car) {
            return $this->deal->car->isOwnedByTaxiCompany();
        }
        return false;
    }
}
