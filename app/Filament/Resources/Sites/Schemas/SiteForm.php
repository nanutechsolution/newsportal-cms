<?php

namespace App\Filament\Resources\Sites\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Website')
                    ->description('Pengaturan dasar untuk multi-website.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Website')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: NusaAksara Jatim'),
                        TextInput::make('domain')
                            ->label('Domain')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: jatim.nusaaksara.com'),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Matikan untuk menonaktifkan website ini sementara.'),
                    ])
                    ->columns(2),
            ]);
    }
}
