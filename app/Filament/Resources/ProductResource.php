<?php

namespace App\Filament\Resources;

use App\Filament\Components\ProductStatusBar;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Services\AddressValidationService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Section::make([
                        TextInput::make('name')
                            ->rules(['required', 'string', 'max:255'])
                            ->markAsRequired(),

                        Textarea::make('description')
                            ->rows(5)
                            ->rules(['required'])
                            ->markAsRequired(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Select::make('product_category_id')
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->relationship('category', 'name'),

                                Select::make('product_color_id')
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->relationship('color', 'name'),
                            ]),

                        TextInput::make('address')
                            ->label('Address')
                            ->placeholder('ex., 20 North Road, Lilydale, VIC 3140, Australia')
                            ->suffixAction(
                                Action::make('verifyAddress')
                                    ->icon('heroicon-o-check-circle')
                                    ->action(function (Get $get, Set $set) {
                                        $address = $get('address');
                                        $service = app(AddressValidationService::class);

                                        try {
                                            if (! $address) {
                                                Notification::make()
                                                    ->title('Address Verification Error')
                                                    ->body('Address cannot be blank.')
                                                    ->danger()
                                                    ->send();

                                                return;
                                            }
                                            $components = $service->parseAddress($address);

                                            $isValid = $service->validateAddress($components);

                                            Notification::make()
                                                ->title($isValid ? 'Address Verified' : 'No Match Found')
                                                ->body(
                                                    $isValid
                                                        ? 'The address is valid and matched successfully.'
                                                        : 'The address could not be verified. Please check the format or try again.'
                                                )
                                                ->{$isValid ? 'success' : 'danger'}()
                                                ->send();

                                        } catch (\Exception $e) {
                                            Notification::make()
                                                ->title('Address Verification Error')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    })
                            ),

                        ProductStatusBar::make('status_bar')->label('Status')->columnSpanFull(),

                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable(),
                TextColumn::make('status')->sortable()->badge(),
                TextColumn::make('color.name')->label('Color')->sortable(),
                TextColumn::make('category.name')->label('Category')->badge(),
            ])
            ->filters([

            ])->actions([
                Tables\Actions\Action::make('Process Now')
                    ->action(function (Product $record) {
                        dispatch(new \App\Jobs\ProcessProduct($record));
                    })
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->label('Process Now'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
