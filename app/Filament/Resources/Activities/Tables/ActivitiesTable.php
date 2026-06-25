<?php

namespace App\Filament\Resources\Activities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('causer.name')
                    ->label('Aktor (User)')
                    ->icon('heroicon-m-user-circle')
                    ->placeholder('Sistem / Guest')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('event')
                    ->label('Tindakan')
                    ->badge() // Badge Dinamis Super Keren
                    ->color(fn(string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        'restored' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state) => ucfirst($state))
                    ->sortable(),

                TextColumn::make('subject_type')
                    ->label('Modul Data')
                    ->formatStateUsing(fn($state) => class_basename($state))
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Deskripsi Aktivitas')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Waktu Kejadian')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('event')
                    ->label('Filter Tindakan')
                    ->options([
                        'created' => 'Penambahan Data (Created)',
                        'updated' => 'Perubahan Data (Updated)',
                        'deleted' => 'Penghapusan Data (Deleted)',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()->label('Detail & Komparasi')
                    ->icon('heroicon-m-magnifying-glass-plus')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
