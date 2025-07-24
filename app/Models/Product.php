<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    /**
     * Automatically assigns product types to a product
     */
    public static function booted()
    {
        // When a new product is created, assign its types from the selected category
        static::created(function (Product $product) {
            if ($product->category) {
                $typeIds = $product->category->productTypes->pluck('id')->toArray();
                $product->productTypes()->sync($typeIds);
            }
        });

        // When updating the product, if category changes, update the types accordingly
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

    public function productTypes(): MorphToMany
    {
        return $this->morphToMany(ProductType::class, 'typeable', 'type_assignments');
    }
}
