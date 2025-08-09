<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Enums\DealStatus;
use App\Enums\DealType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DealsRelationManager extends RelationManager
{
    protected static string $relationship = 'deals';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('car_id')
                    ->relationship('car', 'brand')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Автомобиль'),

                Forms\Components\Select::make('renter_id')
                    ->relationship('renter', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Арендатор'),

                Forms\Components\Select::make('deal_type')
                    ->options(DealType::class)
                    ->required()
                    ->label('Тип сделки'),

                Forms\Components\Select::make('status')
                    ->options(DealStatus::class)
                    ->required()
                    ->label('Статус'),

                Forms\Components\DateTimePicker::make('start_date')
                    ->required()
                    ->label('Дата начала'),

                Forms\Components\DateTimePicker::make('end_date')
                    ->required()
                    ->label('Дата окончания'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('car.brand')
                    ->searchable()
                    ->sortable()
                    ->label('Автомобиль'),

                Tables\Columns\TextColumn::make('renter.name')
                    ->searchable()
                    ->sortable()
                    ->label('Арендатор'),

                Tables\Columns\BadgeColumn::make('deal_type')
                    ->colors([
                        'primary' => DealType::RENTAL_WITHOUT_DEPOSIT,
                        'warning' => DealType::RENTAL_WITH_DEPOSIT,
                        'success' => DealType::RENT_TO_OWN,
                    ])
                    ->label('Тип сделки'),

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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('deal_type')
                    ->options(DealType::class)
                    ->label('Тип сделки'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(DealStatus::class)
                    ->label('Статус'),
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
