<?php

namespace App\Enums;

enum NotificationType: string
{
    case DEAL_REQUEST = 'deal_request';
    case MESSAGE = 'message';
    case DISPUTE = 'dispute';
}
