<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Activitylog\Models\Activity;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar Aktivitas')
                    ->description('Detail riwayat tindakan yang direkam secara permanen oleh sistem.')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('causer.name')
                                    ->label('Aktor Eksekutor')
                                    ->icon('heroicon-m-shield-exclamation')
                                    ->placeholder('System Otomatis / Guest')
                                    ->color('primary'),
                                TextEntry::make('event')
                                    ->label('Tindakan')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'created' => 'success',
                                        'updated' => 'info',
                                        'deleted' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state) => strtoupper($state)),
                                TextEntry::make('created_at')
                                    ->label('Waktu Rekam (Server)')
                                    ->dateTime('d F Y - H:i:s')
                                    ->icon('heroicon-m-clock'),
                            ]),
                    ]),

                Section::make('Forensik Data (Sebelum vs Sesudah)')
                    ->description('Melihat perubahan nilai dari data sebelum dan sesudah diedit oleh pengguna.')
                    ->icon('heroicon-m-arrows-right-left')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                KeyValueEntry::make('properties.old')
                                    ->label('🔴 DATA LAMA (BEFORE)')
                                    ->keyLabel('Kolom Atribut')
                                    ->valueLabel('Nilai Sebelumnya'),

                                KeyValueEntry::make('properties.attributes')
                                    ->label('🟢 DATA BARU (AFTER)')
                                    ->keyLabel('Kolom Atribut')
                                    ->valueLabel('Nilai Baru Disimpan'),
                            ])
                    ])
                    // Panel ini otomatis tersembunyi jika aksi bukan "Update" (karena create/delete tidak punya before/after yang komplit)
                    ->hidden(fn(Activity $record) => !isset($record->properties['old']) || !isset($record->properties['attributes'])),
            ]);
    }
}
