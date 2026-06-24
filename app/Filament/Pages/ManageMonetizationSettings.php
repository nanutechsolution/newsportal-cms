<?php

namespace App\Filament\Pages;

use App\Settings\MonetizationSettings;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageMonetizationSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string|UnitEnum|null $navigationGroup = 'Sistem & Pengaturan';
    protected static ?string $navigationLabel = 'Monetisasi & Iklan';
    protected static ?int $navigationSort = 12;

    protected static string $settings = MonetizationSettings::class;

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Google AdSense')
                    ->description('Pengaturan otomatis untuk integrasi Google AdSense.')
                    ->schema([
                        Toggle::make('is_adsense_active')
                            ->label('Aktifkan Google AdSense')
                            ->default(false),
                        TextInput::make('adsense_client_id')
                            ->label('Publisher ID (Client ID)')
                            ->placeholder('ca-pub-XXXXXXXXXXXXXXXX')
                            ->required(fn(Get $get) => $get('is_adsense_active'))
                            ->visible(fn(Get $get) => $get('is_adsense_active')),
                    ]),

                Section::make('Slot Iklan Custom / Banner')
                    ->description('Masukkan script HTML atau tag <img> untuk iklan custom pada slot yang tersedia.')
                    ->schema([
                        Textarea::make('header_ad_code')
                            ->label('Iklan Header (Di bawah menu utama)')
                            ->rows(3)
                            ->placeholder('<!-- HTML Code here -->'),
                        Textarea::make('sidebar_ad_code')
                            ->label('Iklan Sidebar (Sebelah kanan artikel)')
                            ->rows(3),
                        Textarea::make('article_ad_code')
                            ->label('Iklan Dalam Artikel (Tengah konten)')
                            ->rows(3),
                        Textarea::make('footer_ad_code')
                            ->label('Iklan Footer')
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}
