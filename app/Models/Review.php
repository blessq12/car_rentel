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
}
