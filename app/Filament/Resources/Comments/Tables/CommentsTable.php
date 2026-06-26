<?php

namespace App\Filament\Resources\Comments\Tables;

use App\Models\Comment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guest_name')
                    ->label('Penulis')
                    ->description(fn(Comment $record): string => $record->guest_email)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('article.title')
                    ->label('Artikel Terkait')
                    ->limit(30)
                    ->url(fn(Comment $record) => route('article.show', $record->article->slug), true)
                    ->sortable(),

                TextColumn::make('body')
                    ->label('Komentar')
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'gray' => 'spam',
                    ])
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'spam' => 'Spam',
                    ]),
                SelectFilter::make('article_id')
                    ->label('Artikel')
                    ->relationship('article', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
