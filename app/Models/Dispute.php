<?php

namespace App\Models;

use App\Models\Traits\HasConversationMessages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispute extends Model
{
    use HasFactory, HasConversationMessages;

    protected $fillable = [
        'deal_id',
        'initiator_id',
        'respondent_id',
        'type',
        'description',
        'status',
        'resolution',
        'evidence_path',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'initiator_id');
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'respondent_id');
    }
}
