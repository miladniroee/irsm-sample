<?php

namespace App\Enums;

enum RoleType: string
{
    case Customer = 'customer';
    case Admin = 'admin';
    case Editor = 'editor';
    case Seller = 'seller';
    case ProductEditor = 'product_editor';
}
