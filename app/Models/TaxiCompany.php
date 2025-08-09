<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TaxiCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'logo_path',
        'rating',
        'is_verified',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'rating' => 'float',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'client_id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'client_id');
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class, 'initiator_id');
    }

    public function respondentDisputes(): HasMany
    {
        return $this->hasMany(Dispute::class, 'respondent_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function receivedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    // Получить все отзывы о таксопарке
    public function getReviewsAttribute()
    {
        return $this->receivedReviews()->with('reviewer')->latest()->get();
    }

    // Получить средний рейтинг
    public function getAverageRatingAttribute()
    {
        return $this->receivedReviews()->avg('rating') ?? 0;
    }

    // Получить количество отзывов
    public function getReviewsCountAttribute()
    {
        return $this->receivedReviews()->count();
    }
}
