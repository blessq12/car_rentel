<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversationMessageResource\Pages;
use App\Models\ConversationMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConversationMessageResource extends Resource
{
    protected static ?string $model = ConversationMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Коммуникации';

    protected static ?string $modelLabel = 'Сообщение';

    protected static ?string $pluralModelLabel = 'Сообщения';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('conversation_type')
                    ->options([
                        'App\Models\Chat' => 'Чат',
                        'App\Models\Dispute' => 'Спор',
                    ])
                    ->required()
                    ->label('Тип разговора'),

                Forms\Components\TextInput::make('conversation_id')
                    ->required()
                    ->numeric()
                    ->label('ID разговора'),

                Forms\Components\Select::make('sender_id')
                    ->relationship('sender', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Отправитель'),

                Forms\Components\Select::make('type')
                    ->options([
                        'text' => 'Текст',
                        'photo' => 'Фото',
                        'video' => 'Видео',
                        'file' => 'Файл',
                        'system' => 'Системное',
                    ])
                    ->required()
                    ->label('Тип сообщения'),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->label('Сообщение'),

                Forms\Components\FileUpload::make('media_path')
                    ->directory('conversation-messages/media')
                    ->label('Медиа файл'),

                Forms\Components\Toggle::make('is_read')
                    ->label('Прочитано'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('conversation_type_name')
                    ->label('Тип разговора')
                    ->sortable(),

                Tables\Columns\TextColumn::make('conversation_description')
                    ->label('Разговор')
                    ->limit(50),

                Tables\Columns\TextColumn::make('sender.name')
                    ->searchable()
                    ->sortable()
                    ->label('Отправитель'),

                Tables\Columns\TextColumn::make('content')
                    ->label('Сообщение')
                    ->limit(100)
                    ->wrap(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Тип')
                    ->colors([
                        'primary' => 'text',
                        'success' => 'photo',
                        'warning' => 'video',
                        'gray' => 'file',
                        'danger' => 'system',
                    ]),

                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label('Прочитано'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->label('Отправлено'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('conversation_type')
                    ->options([
                        'App\Models\Chat' => 'Чаты',
                        'App\Models\Dispute' => 'Споры',
                    ])
                    ->label('Тип разговора'),

                Tables\Filters\SelectFilter::make('sender')
                    ->relationship('sender', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Отправитель'),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Текст',
                        'photo' => 'Фото',
                        'video' => 'Видео',
                        'file' => 'Файл',
                        'system' => 'Системные',
                    ])
                    ->label('Тип сообщения'),

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
            'index' => Pages\ListConversationMessages::route('/'),
            'create' => Pages\CreateConversationMessage::route('/create'),
            'edit' => Pages\EditConversationMessage::route('/{record}/edit'),
        ];
    }
}
