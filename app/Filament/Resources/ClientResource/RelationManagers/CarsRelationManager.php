<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Enums\FuelType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CarsRelationManager extends RelationManager
{
    protected static string $relationship = 'cars';

    protected static ?string $recordTitleAttribute = 'brand';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public function table(Table $table): Table
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
            ])
            ->filters([
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
