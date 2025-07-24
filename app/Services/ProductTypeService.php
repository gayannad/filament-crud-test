<?php

namespace App\Services;

class ProductTypeService
{
    /**
     * Generate a unique identifier for a product type.
     */
    public function fetchUniqueNumber(string $type): string
    {
        return 'PT-'.strtoupper(substr($type, 0, 4)).'-'.rand(1000, 9999);
    }
}
