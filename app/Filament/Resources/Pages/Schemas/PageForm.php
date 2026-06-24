<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use App\Models\WidgetRegistry;
class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Halaman')
                    ->schema([
                        Select::make('site_id')
                            ->label('Website')
                            ->relationship('site', 'name')
                            ->required()
                            ->default(fn() => \App\Models\Site::first()?->id),
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required(),
                        Select::make('layout')
                            ->options([
                                'default' => 'Default (Sidebar)',
                                'full-width' => 'Full Width',
                                'homepage-builder' => 'Homepage Builder',
                            ])
                            ->default('default')
                            ->required(),
                    ])->columns(2),

                Section::make('Widget Builder (Khusus Homepage)')
                    ->visible(fn(Get $get) => $get('layout') === 'homepage-builder')
                    ->schema([
                        Repeater::make('widgets')
                            ->relationship('widgets') // Pastikan ada relasi 'widgets' di Model Page
                            ->schema([
                                Select::make('widget_registry_id')
                                    ->label('Pilih Widget')
                                    ->options(WidgetRegistry::where('is_active', true)->pluck('name', 'id'))
                                    ->required(),
                                KeyValue::make('configuration')
                                    ->label('Konfigurasi Widget (JSON)')
                                    ->helperText('Contoh: "limit": 5, "category": "politik"'),
                            ])
                            ->orderColumn()
                            ->columns(2),
                    ]),
            ]);
    }
}
