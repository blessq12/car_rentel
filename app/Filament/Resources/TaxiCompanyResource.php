<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxiCompanyResource\Pages;
use App\Models\TaxiCompany;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxiCompanyResource extends Resource
{
    protected static ?string $model = TaxiCompany::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Организации';

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

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Название'),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Описание'),

                Forms\Components\FileUpload::make('logo_path')
                    ->image()
                    ->directory('taxi-companies/logos')
                    ->label('Логотип'),

                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->default(0)
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(5)
                    ->label('Рейтинг'),

                Forms\Components\Toggle::make('is_verified')
                    ->label('Верифицирован'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Активен'),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Дополнительные данные'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()
                    ->sortable()
                    ->label('Владелец'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),

                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Логотип'),

                Tables\Columns\TextColumn::make('rating')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->sortable()
                    ->label('Рейтинг'),

                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Верифицирован'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Активен'),

                Tables\Columns\TextColumn::make('cars_count')
                    ->counts('cars')
                    ->label('Автомобилей'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Верифицирован'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активен'),

                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name')
                    ->label('Владелец'),
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
            \App\Filament\Resources\TaxiCompanyResource\RelationManagers\CarsRelationManager::class,
            \App\Filament\Resources\TaxiCompanyResource\RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxiCompanies::route('/'),
            'create' => Pages\CreateTaxiCompany::route('/create'),
            'edit' => Pages\EditTaxiCompany::route('/{record}/edit'),
        ];
    }
}
