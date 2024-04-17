<?php

namespace App\Enums;

enum OrderDetailType: string
{
    case Shipping = 'shipping';
    case Billing = 'billing';
}
