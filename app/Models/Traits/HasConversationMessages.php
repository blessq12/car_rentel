<?php

namespace App\Models\Traits;

use App\Models\ConversationMessage;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasConversationMessages
{
    public function messages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class, 'conversation_id')
            ->where('conversation_type', self::class);
    }

    public function addMessage(array $data): ConversationMessage
    {
        $data['conversation_type'] = self::class;
        $data['conversation_id'] = $this->id;

        return $this->messages()->create($data);
    }

    public function addSystemMessage(string $content, array $metadata = []): ConversationMessage
    {
        return $this->addMessage([
            'sender_id' => null, // Системное сообщение
            'type' => 'system',
            'content' => $content,
            'metadata' => $metadata,
        ]);
    }
}
