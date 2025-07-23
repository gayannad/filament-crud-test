<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function getRecord(): Model
    {
        return parent::getRecord()->load([
            'category',
            'color',
            'productTypes', // 👈 Ensure this is eagerly loaded
        ]);
    }
}
