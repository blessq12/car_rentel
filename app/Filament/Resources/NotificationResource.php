<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationGroup = 'Уведомления';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('notifiable_type')
                    ->options([
                        'App\Models\User' => 'Пользователь',
                        'App\Models\Client' => 'Клиент',
                    ])
                    ->required()
                    ->label('Тип получателя'),

                Forms\Components\TextInput::make('notifiable_id')
                    ->required()
                    ->numeric()
                    ->label('ID получателя'),

                Forms\Components\Select::make('type')
                    ->options([
                        'deal_created' => 'Сделка создана',
                        'deal_updated' => 'Сделка обновлена',
                        'deal_cancelled' => 'Сделка отменена',
                        'message_received' => 'Получено сообщение',
                        'review_posted' => 'Оставлен отзыв',
                        'dispute_opened' => 'Открыт спор',
                    ])
                    ->required()
                    ->label('Тип уведомления'),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(1000)
                    ->label('Содержание'),

                Forms\Components\Toggle::make('is_read')
                    ->label('Прочитано'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('notifiable_type')
                    ->label('Тип получателя')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'App\Models\User' => 'Пользователь',
                        'App\Models\Client' => 'Клиент',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('notifiable_id')
                    ->label('ID получателя')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Тип уведомления')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'deal_created' => 'Сделка создана',
                        'deal_updated' => 'Сделка обновлена',
                        'deal_cancelled' => 'Сделка отменена',
                        'message_received' => 'Получено сообщение',
                        'review_posted' => 'Оставлен отзыв',
                        'dispute_opened' => 'Открыт спор',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('content')
                    ->label('Содержание')
                    ->limit(50),

                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label('Прочитано'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'deal_created' => 'Сделка создана',
                        'deal_updated' => 'Сделка обновлена',
                        'deal_cancelled' => 'Сделка отменена',
                        'message_received' => 'Получено сообщение',
                        'review_posted' => 'Оставлен отзыв',
                        'dispute_opened' => 'Открыт спор',
                    ])
                    ->label('Тип уведомления'),

                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Прочитано'),
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
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'edit' => Pages\EditNotification::route('/{record}/edit'),
        ];
    }
}
