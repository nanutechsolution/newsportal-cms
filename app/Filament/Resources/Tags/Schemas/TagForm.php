<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tag')
                    ->schema([
                        Select::make('site_id')
                            ->label('Website')
                            ->relationship('site', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(fn() => \App\Models\Site::first()?->id),
                        TextInput::make('name')
                            ->label('Nama Tag')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, Get $get) {
                                // Mencegah slug duplikat pada website yang sama
                                return $rule->where('site_id', $get('site_id'));
                            }),
                    ])
                    ->columns(1),
            ]);
    }
}
