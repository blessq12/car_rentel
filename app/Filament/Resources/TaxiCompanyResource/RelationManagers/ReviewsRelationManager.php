<?php

namespace App\Filament\Resources\TaxiCompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'receivedReviews';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('reviewer_id')
                    ->relationship('reviewer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Автор'),

                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->label('Оценка'),

                Forms\Components\Textarea::make('comment')
                    ->maxLength(1000)
                    ->label('Комментарий'),

                Forms\Components\Toggle::make('is_verified')
                    ->label('Верифицирован'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Автор'),

                Tables\Columns\TextColumn::make('rating')
                    ->sortable()
                    ->label('Оценка'),

                Tables\Columns\TextColumn::make('comment')
                    ->limit(50)
                    ->label('Комментарий'),

                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Верифицирован'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Создано'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Верифицирован'),

                Tables\Filters\Filter::make('rating')
                    ->form([
                        Forms\Components\TextInput::make('min_rating')
                            ->numeric()
                            ->label('Мин. оценка'),
                        Forms\Components\TextInput::make('max_rating')
                            ->numeric()
                            ->label('Макс. оценка'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['min_rating'],
                                fn($query, $rating) => $query->where('rating', '>=', $rating),
                            )
                            ->when(
                                $data['max_rating'],
                                fn($query, $rating) => $query->where('rating', '<=', $rating),
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
}
