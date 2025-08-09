<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatResource\Pages;
use App\Models\Chat;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatResource extends Resource
{
    protected static ?string $model = Chat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Коммуникации';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\Select::make('deal_id')
                            ->relationship('deal', 'id', function ($query) {
                                return $query->with(['car', 'client', 'renter']);
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Сделка')
                            ->getOptionLabelFromRecordUsing(fn($record) => "Сделка #{$record->id} - {$record->car->brand} {$record->car->model}"),

                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Владелец автомобиля'),

                        Forms\Components\Select::make('renter_id')
                            ->relationship('renter', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Арендатор'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активен')
                            ->helperText('Чат активен и участники могут обмениваться сообщениями'),
                    ])->columns(2),

                Forms\Components\Section::make('Дополнительно')
                    ->schema([
                        Forms\Components\KeyValue::make('metadata')
                            ->label('Дополнительные данные')
                            ->helperText('Дополнительная информация о чате'),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('deal.id')
                    ->sortable()
                    ->label('Сделка')
                    ->description(fn($record) => $record->deal ? "{$record->deal->car->brand} {$record->deal->car->model}" : 'Нет сделки'),

                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()
                    ->sortable()
                    ->label('Владелец')
                    ->description('Автомобиля'),

                Tables\Columns\TextColumn::make('renter.name')
                    ->searchable()
                    ->sortable()
                    ->label('Арендатор')
                    ->description('Клиент'),

                Tables\Columns\TextColumn::make('messages_count')
                    ->counts('messages')
                    ->label('Сообщений'),

                Tables\Columns\TextColumn::make('last_message')
                    ->label('Последнее сообщение')
                    ->getStateUsing(function ($record) {
                        $lastMessage = $record->messages()->latest()->first();
                        return $lastMessage ? $lastMessage->content : 'Нет сообщений';
                    })
                    ->limit(30),

                Tables\Columns\TextColumn::make('last_message_time')
                    ->label('Последняя активность')
                    ->getStateUsing(function ($record) {
                        $lastMessage = $record->messages()->latest()->first();
                        return $lastMessage ? $lastMessage->created_at->diffForHumans() : 'Нет активности';
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Активен'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Создан'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активен'),

                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name')
                    ->label('Владелец'),

                Tables\Filters\SelectFilter::make('renter')
                    ->relationship('renter', 'name')
                    ->label('Арендатор'),

                Tables\Filters\Filter::make('has_messages')
                    ->query(fn($query) => $query->whereHas('messages'))
                    ->label('С сообщениями'),

                Tables\Filters\Filter::make('recent_activity')
                    ->query(fn($query) => $query->whereHas('messages', function ($q) {
                        $q->where('created_at', '>=', now()->subDays(7));
                    }))
                    ->label('Активность за неделю'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_messages')
                    ->label('Сообщения')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->url(fn(Chat $record): string => route('filament.admin.resources.chats.edit', ['record' => $record, 'activeTab' => 'messages']))
                    ->openUrlInNewTab(),

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
            \App\Filament\Resources\ChatResource\RelationManagers\MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'create' => Pages\CreateChat::route('/create'),
            'edit' => Pages\EditChat::route('/{record}/edit'),
        ];
    }
}
