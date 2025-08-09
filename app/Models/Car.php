<?php

namespace App\Models;

use App\Enums\FuelType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'taxi_company_id',
        'city_id',
        'brand',
        'model',
        'year',
        'fuel_type',
        'price_per_day',
        'is_promoted',
        'is_moderated',
        'metadata',
    ];

    protected $casts = [
        'year' => 'integer',
        'price_per_day' => 'decimal:2',
        'is_promoted' => 'boolean',
        'is_moderated' => 'boolean',
        'metadata' => 'array',
        'fuel_type' => FuelType::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function taxiCompany(): BelongsTo
    {
        return $this->belongsTo(TaxiCompany::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    // Получить владельца (клиент или таксопарк)
    public function getOwnerAttribute()
    {
        return $this->taxiCompany ?? $this->client;
    }

    // Проверить, принадлежит ли автомобиль таксопарку
    public function isOwnedByTaxiCompany(): bool
    {
        return !is_null($this->taxi_company_id);
    }

    // Получить название владельца
    public function getOwnerNameAttribute(): string
    {
        if ($this->isOwnedByTaxiCompany()) {
            return $this->taxiCompany->name;
        }
        return $this->client->name;
    }
}
