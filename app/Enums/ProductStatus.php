<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Pending = 'pending';
    case Draft = 'draft';
    case Published = 'published';
}
