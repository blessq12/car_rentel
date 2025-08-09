<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ConversationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_type',
        'conversation_id',
        'sender_id',
        'type',
        'content',
        'media_path',
        'is_read',
        'metadata',
    ];

    protected $casts = [
        'type' => MessageType::class,
        'is_read' => 'boolean',
        'metadata' => 'array',
    ];

    public function conversation(): MorphTo
    {
        return $this->morphTo();
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'sender_id');
    }

    // Получить название типа разговора
    public function getConversationTypeNameAttribute(): string
    {
        return match ($this->conversation_type) {
            'App\Models\Chat' => 'Чат',
            'App\Models\Dispute' => 'Спор',
            default => $this->conversation_type,
        };
    }

    // Получить краткое описание разговора
    public function getConversationDescriptionAttribute(): string
    {
        if (!$this->conversation) {
            return 'Разговор не найден';
        }

        return match ($this->conversation_type) {
            'App\Models\Chat' => "Чат по сделке #{$this->conversation->deal_id}",
            'App\Models\Dispute' => "Спор #{$this->conversation->id}",
            default => "Разговор #{$this->conversation->id}",
        };
    }
}
