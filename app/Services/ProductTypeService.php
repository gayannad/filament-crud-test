<?php

namespace App\Services;

class ProductTypeService
{
    public function fetchUniqueNumber(string $type): string
    {
        return 'PT-'.strtoupper(substr($type, 0, 4)).'-'.rand(1000, 9999);
    }
}
