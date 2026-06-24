<?php

namespace App\Filament\Pages;

use App\Settings\SeoSettings;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageSeoSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static string|UnitEnum|null $navigationGroup = 'Sistem & Pengaturan';
    protected static ?string $navigationLabel = 'SEO & Analytics';
    protected static ?int $navigationSort = 11;

    protected static string $settings = SeoSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('SEO Settings')
                    ->tabs([
                        Tabs\Tab::make('Meta Tags')
                            ->icon('heroicon-m-tag')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title Global')
                                    ->required(),
                                Textarea::make('meta_description')
                                    ->label('Meta Description Global')
                                    ->rows(3)
                                    ->required(),
                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->helperText('Pisahkan dengan koma. Contoh: berita, daerah, terkini'),
                                TextInput::make('twitter_handle')
                                    ->label('Twitter Handle')
                                    ->prefix('@')
                                    ->placeholder('nusaaksara'),
                                FileUpload::make('og_image_url')
                                    ->label('Default Open Graph Image')
                                    ->image()
                                    ->directory('settings/seo'),
                            ]),

                        Tabs\Tab::make('Google Integrations')
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics Measurement ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->helperText('Kosongkan jika tidak menggunakan Google Analytics GA4.'),
                                Textarea::make('google_search_console_code')
                                    ->label('Google Search Console Verification Code')
                                    ->rows(2)
                                    ->placeholder('<meta name="google-site-verification" content="..." />'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
