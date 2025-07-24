<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Form;

class ProductStatusBar extends Field
{
    // the custom Blade view used to render the field in the product form
    protected string $view = 'filament.components.product-status-bar';

    // Set up default configuration for the field
    protected function setUp(): void
    {
        parent::setUp();

        // Prevents this field from being submitted with form data
        // Useful for display-only or read-only components
        $this->dehydrated(false);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ProductStatusBar::make('status_bar'),
            ]);
    }
}
