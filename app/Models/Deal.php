<?php

namespace App\Models;

use App\Enums\DealStatus;
use App\Enums\DealType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'client_id',
        'renter_id',
        'status',
        'deal_type',
        'contract_path',
        'start_date',
        'end_date',
        'metadata',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'metadata' => 'array',
        'status' => DealStatus::class,
        'deal_type' => DealType::class,
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function renter(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'renter_id');
    }

    // Получить арендодателя (клиент или таксопарк)
    public function getOwnerAttribute()
    {
        return $this->car->owner;
    }

    // Получить название арендодателя
    public function getOwnerNameAttribute(): string
    {
        return $this->car->owner_name;
    }

    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class);
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
