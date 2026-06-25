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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Informasi Halaman')
                            ->schema([
                                Select::make('site_id')
                                    ->label('Website')
                                    ->relationship('site', 'name')
                                    ->required()
                                    ->searchable()
                                    ->default(fn() => \App\Models\Site::first()?->id),

                                TextInput::make('title')
                                    ->label('Judul Halaman')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Slug / URL')
                                    ->required()
                                    ->unique(ignoreRecord: true, modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, Get $get) {
                                        return $rule->where('site_id', $get('site_id'));
                                    }),

                                Select::make('layout')
                                    ->label('Tipe Layout')
                                    ->options([
                                        'default' => 'Default (Halaman Statis Biasa)',
                                        'full-width' => 'Full Width (Tanpa Sidebar)',
                                        'homepage-builder' => 'Homepage Builder (Drag & Drop Widget)',
                                    ])
                                    ->default('default')
                                    ->required()
                                    ->live(), // "live()" membuat form reaktif saat pilihan ini diubah

                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ])->columns(2),

                        // Section ini HANYA MUNCUL jika layout BUKAN homepage-builder
                        Section::make('Konten Halaman Statis')
                            ->description('Tulis konten statis untuk halaman seperti Tentang Kami, Kontak, dll.')
                            ->schema([
                                RichEditor::make('content')
                                    ->label('Isi Konten')
                                    ->fileAttachmentsDirectory('pages')
                                    ->columnSpanFull(),
                            ])
                            ->hidden(fn(Get $get) => $get('layout') === 'homepage-builder'),

                        // Section ini HANYA MUNCUL jika layout ADALAH homepage-builder
                        Section::make('Dynamic Widget Builder')
                            ->description('Susun tata letak halaman depan menggunakan widget yang tersedia. Geser (Drag) untuk mengubah urutan.')
                            ->schema([
                                Repeater::make('widgets')
                                    ->label('Daftar Widget')
                                    ->relationship('widgets') // Memanggil relasi ->widgets() di Model Page
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get) {
                                        // Secara otomatis memasukkan site_id ke dalam tabel pivot page_widgets
                                        $data['site_id'] = $get('../../site_id');
                                        return $data;
                                    })
                                    ->schema([
                                        Select::make('widget_registry_id')
                                            ->label('Tipe Widget')
                                            ->options(WidgetRegistry::where('is_active', true)->pluck('name', 'id'))
                                            ->required()
                                            ->searchable()
                                            ->live()
                                            // Memasukkan konfigurasi bawaan secara otomatis saat widget dipilih
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                $registry = WidgetRegistry::find($state);
                                                if ($registry && $registry->default_config_schema) {
                                                    $set('configuration', $registry->default_config_schema);
                                                }
                                            }),

                                        KeyValue::make('configuration')
                                            ->label('Konfigurasi Widget Parameter')
                                            ->keyLabel('Nama Parameter (Misal: limit)')
                                            ->valueLabel('Nilai (Misal: 5)')
                                            ->addActionLabel('Tambah Parameter'),
                                    ])
                                    ->orderColumn('order_column') // Kolom database untuk menyimpan urutan drag-and-drop
                                    ->collapsible()
                                    ->itemLabel(fn(array $state): ?string => WidgetRegistry::find($state['widget_registry_id'] ?? null)?->name ?? 'Widget Baru')
                                    ->columns(2),
                            ])
                            ->visible(fn(Get $get) => $get('layout') === 'homepage-builder'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
