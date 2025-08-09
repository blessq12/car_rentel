<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisputeResource\Pages;
use App\Models\Dispute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DisputeResource extends Resource
{
    protected static ?string $model = Dispute::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'Споры';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('deal_id')
                    ->relationship('deal', 'id')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Сделка'),

                Forms\Components\Select::make('initiator_id')
                    ->relationship('initiator', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Инициатор'),

                Forms\Components\Select::make('respondent_id')
                    ->relationship('respondent', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Ответчик'),

                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->label('Тип спора'),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Описание'),

                Forms\Components\Select::make('status')
                    ->options([
                        'open' => 'Открыт',
                        'in_progress' => 'В процессе',
                        'resolved' => 'Решен',
                        'closed' => 'Закрыт',
                    ])
                    ->required()
                    ->label('Статус'),

                Forms\Components\Textarea::make('resolution')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Решение'),

                Forms\Components\FileUpload::make('evidence_path')
                    ->directory('disputes/evidence')
                    ->label('Доказательства'),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Дополнительные данные'),
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

                Tables\Columns\TextColumn::make('initiator.name')
                    ->searchable()
                    ->sortable()
                    ->label('Инициатор'),

                Tables\Columns\TextColumn::make('respondent.name')
                    ->searchable()
                    ->sortable()
                    ->label('Ответчик'),

                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->label('Тип спора'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'open',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ])
                    ->label('Статус'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->label('Описание'),

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

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Создан'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Открыт',
                        'in_progress' => 'В процессе',
                        'resolved' => 'Решен',
                        'closed' => 'Закрыт',
                    ])
                    ->label('Статус'),

                Tables\Filters\SelectFilter::make('initiator')
                    ->relationship('initiator', 'name')
                    ->label('Инициатор'),

                Tables\Filters\SelectFilter::make('respondent')
                    ->relationship('respondent', 'name')
                    ->label('Ответчик'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_messages')
                    ->label('Переговоры')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn($record): string => route('filament.admin.resources.disputes.edit', ['record' => $record, 'activeTab' => 'messages']))
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
            \App\Filament\Resources\DisputeResource\RelationManagers\MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisputes::route('/'),
            'create' => Pages\CreateDispute::route('/create'),
            'edit' => Pages\EditDispute::route('/{record}/edit'),
        ];
    }
}
