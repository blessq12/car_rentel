<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'email',
        'telegram_nickname',
        'name',
        'phone',
        'rating',
        'dispute_count',
        'is_verified',
        'referrer_id',
        'metadata',
    ];

    protected $casts = [
        'rating' => 'float',
        'dispute_count' => 'integer',
        'is_verified' => 'boolean',
        'metadata' => 'array',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'referrer_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Client::class, 'referrer_id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'client_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Deal::class, 'renter_id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
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

    public function taxiCompanies(): HasMany
    {
        return $this->hasMany(TaxiCompany::class);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
