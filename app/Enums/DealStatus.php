<?php

namespace App\Enums;

enum DealStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}
