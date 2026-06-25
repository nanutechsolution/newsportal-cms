<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Halaman')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('layout')
                    ->label('Tipe Layout')
                    ->colors([
                        'primary' => 'default',
                        'warning' => 'full-width',
                        'success' => 'homepage-builder',
                    ])->badge()
                    ->formatStateUsing(fn(string $state): string => ucwords(str_replace('-', ' ', $state))),
                TextColumn::make('site.name')
                    ->label('Website')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('site_id')
                    ->label('Filter Website')
                    ->relationship('site', 'name'),
                SelectFilter::make('layout')
                    ->label('Tipe Layout')
                    ->options([
                        'default' => 'Default',
                        'full-width' => 'Full Width',
                        'homepage-builder' => 'Homepage Builder',
                    ]),
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
