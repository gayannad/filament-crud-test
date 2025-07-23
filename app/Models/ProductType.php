<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public function products()
    {
        return $this->morphedByMany(Product::class, 'typeable', 'type_assignments');
    }

    public function categories()
    {
        return $this->morphedByMany(ProductCategory::class, 'typeable', 'type_assignments');
    }
}
