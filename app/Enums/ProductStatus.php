<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Pending = 'pending';
    case Processed = 'processed';
}
