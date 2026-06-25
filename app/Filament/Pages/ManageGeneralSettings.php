<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static string|UnitEnum|null $navigationGroup = 'Sistem & Pengaturan';
    protected static ?string $navigationLabel = 'Identitas Website';
    protected static ?int $navigationSort = 10;

    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Pengaturan')
                    ->tabs([
                        Tabs\Tab::make('Identitas Dasar')
                            ->icon('heroicon-m-identification')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Nama Website')
                                    ->required(),
                                Textarea::make('site_description')
                                    ->label('Deskripsi Website (SEO Meta)')
                                    ->rows(3)
                                    ->required(),
                                Grid::make(2)
                                    ->schema([
                                        FileUpload::make('logo_url')
                                            ->label('Logo Utama')
                                            ->image()
                                            ->disk('public')
                                            ->directory('settings/logo'),
                                        FileUpload::make('favicon_url')
                                            ->label('Favicon')
                                            ->disk('public')
                                            ->image()
                                            ->directory('settings/favicon'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Kontak & Alamat')
                            ->icon('heroicon-m-phone')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('contact_email')
                                            ->label('Email Redaksi')
                                            ->email()
                                            ->required(),
                                        TextInput::make('contact_phone')
                                            ->label('Nomor Telepon')
                                            ->tel()
                                            ->required(),
                                    ]),
                                Textarea::make('address')
                                    ->label('Alamat Kantor Redaksi')
                                    ->rows(3)
                                    ->required(),
                            ]),

                        Tabs\Tab::make('Sosial Media')
                            ->icon('heroicon-m-share')
                            ->schema([
                                TextInput::make('social_facebook')
                                    ->label('URL Facebook')
                                    ->url(),
                                TextInput::make('social_instagram')
                                    ->label('URL Instagram')
                                    ->url(),
                                TextInput::make('social_twitter')
                                    ->label('URL X / Twitter')
                                    ->url(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
