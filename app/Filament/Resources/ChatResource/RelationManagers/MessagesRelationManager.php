<?php

namespace App\Filament\Resources\ChatResource\RelationManagers;


use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;


class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sender_id')
                    ->relationship('sender', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Отправитель'),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->label('Сообщение'),

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

                Forms\Components\FileUpload::make('media_path')
                    ->directory('conversation-messages/media')
                    ->label('Медиа файл'),

                Forms\Components\Toggle::make('is_read')
                    ->label('Прочитано'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Отправитель')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('content')
                    ->label('Сообщение')
                    ->wrap()
                    ->limit(100),

                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Время')
                //     ->dateTime('d.m.Y H:i')
                //     ->sortable(),

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
            ])
            ->filters([
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
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
