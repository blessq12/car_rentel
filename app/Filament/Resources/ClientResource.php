<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Пользователи';

    protected static ?string $modelLabel = 'Клиент';

    protected static ?string $pluralModelLabel = 'Клиенты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Имя'),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->label('Email'),

                        Forms\Components\TextInput::make('telegram_nickname')
                            ->maxLength(255)
                            ->label('Telegram')
                            ->prefix('@'),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255)
                            ->label('Телефон'),
                    ])->columns(2),

                Forms\Components\Section::make('Местоположение и статус')
                    ->schema([
                        Forms\Components\Select::make('city_id')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Город'),

                        Forms\Components\TextInput::make('rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->label('Рейтинг')
                            ->suffix('⭐'),

                        Forms\Components\TextInput::make('dispute_count')
                            ->numeric()
                            ->minValue(0)
                            ->label('Количество споров')
                            ->suffix('споров'),

                        Forms\Components\Toggle::make('is_verified')
                            ->label('Верифицирован')
                            ->helperText('Пользователь прошел верификацию через Telegram'),
                    ])->columns(2),

                Forms\Components\Section::make('Реферальная система')
                    ->schema([
                        Forms\Components\Select::make('referrer_id')
                            ->relationship('referrer', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Реферер')
                            ->helperText('Кто пригласил этого пользователя'),

                        Forms\Components\KeyValue::make('metadata')
                            ->label('Дополнительные данные')
                            ->helperText('Дополнительная информация о пользователе'),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Имя')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email')
                    ->copyable(),

                Tables\Columns\TextColumn::make('telegram_nickname')
                    ->searchable()
                    ->label('Telegram')
                    ->prefix('@'),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('Телефон')
                    ->copyable(),

                Tables\Columns\TextColumn::make('rating')
                    ->numeric(
                        decimalPlaces: 1,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->sortable()
                    ->label('Рейтинг')
                    ->suffix('⭐')
                    ->color(fn(string $state): string => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 3.5 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('dispute_count')
                    ->sortable()
                    ->label('Споры')
                    ->color(fn(string $state): string => match (true) {
                        $state == 0 => 'success',
                        $state <= 2 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('city.name')
                    ->searchable()
                    ->sortable()
                    ->label('Город'),

                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Верифицирован')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('cars_count')
                    ->counts('cars')
                    ->label('Автомобили'),

                Tables\Columns\TextColumn::make('deals_count')
                    ->counts('deals')
                    ->label('Сделки'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->relationship('city', 'name')
                    ->label('Город'),

                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Верифицирован'),

                Tables\Filters\Filter::make('high_rating')
                    ->query(fn(Builder $query): Builder => $query->where('rating', '>=', 4.5))
                    ->label('Высокий рейтинг'),

                Tables\Filters\Filter::make('problematic')
                    ->query(fn(Builder $query): Builder => $query->where('dispute_count', '>=', 3))
                    ->label('Проблемные пользователи'),

                Tables\Filters\Filter::make('has_telegram')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('telegram_nickname'))
                    ->label('С Telegram'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_cars')
                    ->label('Автомобили')
                    ->icon('heroicon-o-truck')
                    ->url(fn(Client $record): string => route('filament.admin.resources.cars.index', ['tableFilters[client_id][value]' => $record->id]))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('view_deals')
                    ->label('Сделки')
                    ->icon('heroicon-o-currency-dollar')
                    ->url(fn(Client $record): string => route('filament.admin.resources.deals.index', ['tableFilters[client_id][value]' => $record->id]))
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify')
                        ->label('Верифицировать')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_verified' => true]);
                            });
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('unverify')
                        ->label('Снять верификацию')
                        ->icon('heroicon-o-x-circle')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_verified' => false]);
                            });
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['cars', 'deals']);
    }
}
