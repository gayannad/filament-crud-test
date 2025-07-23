<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Form;

class ProductStatusBar extends Field
{
    protected string $view = 'filament.components.product-status-bar';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false); // don't save in form data
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ProductStatusBar::make('status_bar'),
            ]);
    }
}
