<?php

namespace App\Enums;

enum OrderItemType: string
{
    case Product = 'product';
    case Shipping = 'shipping';
    case Discount = 'discount';
}
