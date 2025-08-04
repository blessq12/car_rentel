<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Отзывы';

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

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Автор'),

                Forms\Components\Select::make('target_client_id')
                    ->relationship('targetClient', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Получатель'),

                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->label('Оценка'),

                Forms\Components\Textarea::make('comment')
                    ->maxLength(1000)
                    ->label('Комментарий'),

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
                    ->label('Автор'),

                Tables\Columns\TextColumn::make('targetClient.name')
                    ->searchable()
                    ->sortable()
                    ->label('Получатель'),

                Tables\Columns\TextColumn::make('rating')
                    ->sortable()
                    ->label('Оценка'),

                Tables\Columns\TextColumn::make('comment')
                    ->limit(50)
                    ->label('Комментарий'),

                Tables\Columns\TextColumn::make('deal.id')
                    ->sortable()
                    ->label('Сделка'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name')
                    ->label('Автор'),

                Tables\Filters\SelectFilter::make('targetClient')
                    ->relationship('targetClient', 'name')
                    ->label('Получатель'),

                Tables\Filters\Filter::make('rating')
                    ->form([
                        Forms\Components\TextInput::make('min_rating')
                            ->numeric()
                            ->label('Мин. оценка'),
                        Forms\Components\TextInput::make('max_rating')
                            ->numeric()
                            ->label('Макс. оценка'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_rating'],
                                fn(Builder $query, $rating): Builder => $query->where('rating', '>=', $rating),
                            )
                            ->when(
                                $data['max_rating'],
                                fn(Builder $query, $rating): Builder => $query->where('rating', '<=', $rating),
                            );
                    })
                    ->label('Оценка'),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
