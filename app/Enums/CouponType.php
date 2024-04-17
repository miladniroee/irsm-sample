<?php

namespace App\Enums;

enum CouponType: string
{
    case FixedCard = 'fixed_card';
    case FixedProduct = 'fixed_product';
    case Percent = 'percent';
}
