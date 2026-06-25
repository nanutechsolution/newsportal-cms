<?php

namespace App\Filament\Resources\WidgetRegistries\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WidgetRegistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Widget')
                    ->description('Daftarkan class widget baru agar bisa digunakan di Homepage Builder.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Widget (Tampilan UI)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Banner Iklan Header'),

                        TextInput::make('class_name')
                            ->label('Class PHP (Namespace)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: App\Widgets\BannerAdsWidget')
                            ->helperText('Pastikan file class PHP ini sudah Anda buat di folder app/Widgets/'),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2),

                Section::make('Skema Konfigurasi Default')
                    ->description('Parameter bawaan yang akan langsung terisi saat admin memilih widget ini di Page Builder.')
                    ->schema([
                        KeyValue::make('default_config_schema')
                            ->label('Parameter Konfigurasi')
                            ->keyLabel('Nama Parameter (Misal: limit)')
                            ->valueLabel('Nilai Default (Misal: 5)')
                            ->addActionLabel('Tambah Parameter Baru'),
                    ]),
            ]);
    }
}
