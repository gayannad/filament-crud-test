<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    public static function booted()
    {
        static::created(function (Product $product) {
            if ($product->category) {
                $typeIds = $product->category->productTypes->pluck('id')->toArray();
                $product->productTypes()->sync($typeIds);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('product_category_id')) {
                $typeIds = $product->category->productTypes->pluck('id')->toArray();
                $product->productTypes()->sync($typeIds);
            }
        });
    }

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function productTypes()
    {
        return $this->morphToMany(ProductType::class, 'typeable', 'type_assignments');
    }
}
