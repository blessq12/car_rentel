<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use App\Models\City;
use App\Models\Client;
use App\Enums\FuelType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Автопрокат';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Владелец'),

                Forms\Components\Select::make('taxi_company_id')
                    ->relationship('taxiCompany', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Таксопарк')
                    ->placeholder('Выберите таксопарк (необязательно)'),

                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Город'),

                Forms\Components\TextInput::make('brand')
                    ->required()
                    ->maxLength(255)
                    ->label('Марка'),

                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255)
                    ->label('Модель'),

                Forms\Components\TextInput::make('year')
                    ->required()
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y') + 1)
                    ->label('Год выпуска'),

                Forms\Components\Select::make('fuel_type')
                    ->options(FuelType::class)
                    ->required()
                    ->label('Тип топлива'),

                Forms\Components\TextInput::make('price_per_day')
                    ->required()
                    ->numeric()
                    ->prefix('₽')
                    ->label('Цена за день'),

                Forms\Components\Toggle::make('is_promoted')
                    ->label('Продвигается'),

                Forms\Components\Toggle::make('is_moderated')
                    ->label('Прошло модерацию'),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Дополнительные данные'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->sortable()
                    ->label('Марка'),

                Tables\Columns\TextColumn::make('model')
                    ->searchable()
                    ->sortable()
                    ->label('Модель'),

                Tables\Columns\TextColumn::make('owner_name')
                    ->label('Владелец')
                    ->description(fn($record) => $record->isOwnedByTaxiCompany() ? 'Таксопарк' : 'Частное лицо'),

                Tables\Columns\TextColumn::make('city.name')
                    ->searchable()
                    ->sortable()
                    ->label('Город'),

                Tables\Columns\TextColumn::make('year')
                    ->sortable()
                    ->label('Год'),

                Tables\Columns\TextColumn::make('fuel_type')
                    ->badge()
                    ->label('Топливо'),

                Tables\Columns\TextColumn::make('price_per_day')
                    ->money('RUB')
                    ->sortable()
                    ->label('Цена/день'),

                Tables\Columns\IconColumn::make('is_promoted')
                    ->boolean()
                    ->label('Продвигается'),

                Tables\Columns\IconColumn::make('is_moderated')
                    ->boolean()
                    ->label('Промодерирован'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('owner_type')
                    ->options([
                        'private' => 'Частные лица',
                        'taxi_company' => 'Таксопарки',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['value'] === 'private') {
                            return $query->whereNull('taxi_company_id');
                        }
                        if ($data['value'] === 'taxi_company') {
                            return $query->whereNotNull('taxi_company_id');
                        }
                        return $query;
                    })
                    ->label('Тип владельца'),

                Tables\Filters\SelectFilter::make('city')
                    ->relationship('city', 'name')
                    ->label('Город'),

                Tables\Filters\SelectFilter::make('fuel_type')
                    ->options([
                        'petrol' => 'Бензин',
                        'diesel' => 'Дизель',
                        'electric' => 'Электро',
                        'hybrid' => 'Гибрид',
                    ])
                    ->label('Топливо'),

                Tables\Filters\TernaryFilter::make('is_promoted')
                    ->label('Продвигается'),

                Tables\Filters\TernaryFilter::make('is_moderated')
                    ->label('Прошло модерацию'),
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
            \App\Filament\Resources\CarResource\RelationManagers\DealsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
