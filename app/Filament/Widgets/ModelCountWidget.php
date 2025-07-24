<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ModelCountWidget extends BaseWidget
{
    /**
     * for display dashboard statistics
     */
    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Users',
                value: User::query()
                    ->count(),
            ),

            Stat::make(
                label: 'Categories',
                value: ProductCategory::query()
                    ->count(),
            ),

            Stat::make(
                label: 'Types',
                value: ProductType::query()
                    ->count(),
            ),

            Stat::make(
                label: 'Colors',
                value: ProductColor::query()
                    ->count(),
            ),

            Stat::make(
                label: 'Products',
                value: Product::query()
                    ->count(),
            ),

        ];
    }
}
