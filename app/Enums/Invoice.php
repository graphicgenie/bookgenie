<?php

namespace App\Enums;

enum Invoice: string
{
    case SALES_INVOICE = 'sales_invoice';
    case PURCHASE_INVOICE = 'purchase_invoice';
}
