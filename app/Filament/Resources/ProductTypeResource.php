<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTypeResource\Pages;
use App\Models\ProductType;
use App\Services\ProductTypeService;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $label = 'Types';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Section::make([
                        TextInput::make('name')
                            ->rules(['required', 'string', 'max:255'])
                            ->markAsRequired()
                            ->afterStateUpdated(function (Get $get, $state, $set) {
                                if ($state) {
                                    $service = new ProductTypeService;
                                    $set('api_unique_number', $service->fetchUniqueNumber($state));
                                }
                            })
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('Fetch')
                                    ->action(function ($state, Forms\Set $set) {
                                        $service = new ProductTypeService;
                                        $unique = $service->fetchUniqueNumber($state);
                                        $set('api_unique_number', $unique);
                                    })
                                    ->icon('heroicon-o-rectangle-stack')
                                    ->tooltip('Fetch API Unique Number')
                            ),

                        TextInput::make('api_unique_number')
                            ->readOnly(),
                    ]),
                ])
                    ->from('2xl')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('api_unique_number')
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductTypes::route('/'),
            'create' => Pages\CreateProductType::route('/create'),
            'edit' => Pages\EditProductType::route('/{record}/edit'),
        ];
    }
}
