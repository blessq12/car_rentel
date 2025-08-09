<?php

namespace App\Enums;

enum MessageType: string
{
    case TEXT = 'text';
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case FILE = 'file';
    case SYSTEM = 'system';
}
