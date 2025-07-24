<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ProductType extends Model
{
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'typeable', 'type_assignments');
    }

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(ProductCategory::class, 'typeable', 'type_assignments');
    }
}
