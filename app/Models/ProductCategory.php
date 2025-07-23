<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public function productTypes()
    {
        return $this->morphToMany(ProductType::class, 'typeable', 'type_assignments');
    }
}
