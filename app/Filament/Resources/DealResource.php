<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DealResource\Pages;
use App\Models\Deal;
use App\Enums\DealStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Сделки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('car_id')
                    ->relationship('car', 'brand')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Автомобиль'),

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Владелец'),

                Forms\Components\Select::make('renter_id')
                    ->relationship('renter', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Арендатор'),

                Forms\Components\Select::make('status')
                    ->options(DealStatus::class)
                    ->required()
                    ->label('Статус'),

                Forms\Components\FileUpload::make('contract_path')
                    ->label('Контракт')
                    ->directory('contracts'),

                Forms\Components\DateTimePicker::make('start_date')
                    ->required()
                    ->label('Дата начала'),

                Forms\Components\DateTimePicker::make('end_date')
                    ->required()
                    ->label('Дата окончания'),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Дополнительные данные'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('car.brand')
                    ->searchable()
                    ->sortable()
                    ->label('Автомобиль'),

                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()
                    ->sortable()
                    ->label('Владелец'),

                Tables\Columns\TextColumn::make('renter.name')
                    ->searchable()
                    ->sortable()
                    ->label('Арендатор'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => DealStatus::CANCELED,
                        'warning' => DealStatus::PENDING,
                        'success' => DealStatus::COMPLETED,
                        'info' => DealStatus::ACCEPTED,
                    ])
                    ->label('Статус'),

                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable()
                    ->label('Начало'),

                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable()
                    ->label('Окончание'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(DealStatus::class)
                    ->label('Статус'),

                Tables\Filters\SelectFilter::make('car')
                    ->relationship('car', 'brand')
                    ->label('Автомобиль'),

                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name')
                    ->label('Владелец'),

                Tables\Filters\SelectFilter::make('renter')
                    ->relationship('renter', 'name')
                    ->label('Арендатор'),
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
            'index' => Pages\ListDeals::route('/'),
            'create' => Pages\CreateDeal::route('/create'),
            'edit' => Pages\EditDeal::route('/{record}/edit'),
        ];
    }
} 