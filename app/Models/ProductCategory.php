<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ProductCategory extends Model
{
    public function productTypes(): MorphToMany
    {
        return $this->morphToMany(ProductType::class, 'typeable', 'type_assignments');
    }
}
