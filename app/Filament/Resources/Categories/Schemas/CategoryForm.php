<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Informasi Utama')
                            ->schema([
                                Select::make('site_id')
                                    ->label('Website')
                                    ->relationship('site', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->default(fn() => \App\Models\Site::first()?->id),

                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true, modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, Get $get) {
                                        return $rule->where('site_id', $get('site_id'));
                                    }),

                                Textarea::make('description')
                                    ->label('Deskripsi Singkat')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Hierarki & Tampilan')
                            ->schema([
                                Select::make('parent_id')
                                    ->label('Induk Kategori')
                                    ->relationship('parent', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Pilih Jika Sub-Kategori'),

                                ColorPicker::make('color_hex')
                                    ->label('Warna Kategori'),

                                TextInput::make('icon_class')
                                    ->label('Ikon (Class CSS/Heroicon)')
                                    ->maxLength(255)
                                    ->placeholder('Misal: heroicon-o-fire'),

                                TextInput::make('order_column')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Angka lebih kecil tampil lebih dulu.'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
