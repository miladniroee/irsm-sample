<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case TO_CARD = 'to_card';
    case POS = 'p.o.s';
    case ZARRINPAL = 'zarrinpal';
}
