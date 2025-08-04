<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'type',
        'content',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'type' => NotificationType::class,
    ];

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
