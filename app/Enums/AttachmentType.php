<?php

namespace App\Enums;

enum AttachmentType: string
{
    case Image = 'image';
    case Video = 'video';
    case Audio = 'audio';
    case Compressed = 'compressed';
    case Document = 'document';
    case Other = 'other';
}
