<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Konten Utama')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Berita')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true, modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, Get $get) {
                                        return $rule->where('site_id', $get('site_id'));
                                    }),

                                Textarea::make('excerpt')
                                    ->label('Kutipan Singkat (Excerpt)')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Ringkasan berita yang akan muncul di halaman depan. Kosongkan untuk mengambil otomatis dari paragraf pertama.'),

                                RichEditor::make('content')
                                    ->label('Isi Berita')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('articles/content')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Section::make('Media & Thumbnail')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('cover')
                                    ->collection('cover')
                                    ->label('Gambar Utama (Cover)')
                                    ->image()
                                    ->imageEditor() // Memungkinkan crop gambar langsung di admin
                                    // ->optimize('webp') // Otomatis convert ke WebP
                                    ->maxSize(2048) // Maksimal 2MB
                                    ->required(),
                            ]),

                        Section::make('SEO Metadata')
                            ->description('Atur meta tag khusus untuk optimasi mesin pencari pada berita ini.')
                            ->relationship('seoMetadata')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(255)
                                    ->helperText('Kosongkan untuk menggunakan Judul Berita.'),
                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(2)
                                    ->maxLength(255)
                                    ->helperText('Kosongkan untuk menggunakan Kutipan (Excerpt).'),
                                TextInput::make('canonical_url')
                                    ->label('Canonical URL')
                                    ->url()
                                    ->maxLength(255),
                            ])
                            ->collapsed(), // Ditutup secara default agar form tidak terlalu panjang
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Organisasi')
                            ->schema([
                                Select::make('site_id')
                                    ->label('Website')
                                    ->relationship('site', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->default(fn() => \App\Models\Site::first()?->id),

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Select::make('tags')
                                    ->label('Tag')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')->required(),
                                        Hidden::make('site_id')->default(fn(Get $get) => $get('../../site_id')),
                                    ]),
                            ]),

                        Section::make('Status & Visibilitas')
                            ->schema([
                                Select::make('status')
                                    ->label('Status Workflow')
                                    ->options(ArticleStatus::class)
                                    ->required()
                                    ->default(ArticleStatus::Draft),

                                DateTimePicker::make('published_at')
                                    ->label('Jadwal Tayang')
                                    ->helperText('Atur tanggal di masa depan untuk menjadwalkan otomatis.'),

                                Toggle::make('is_featured')
                                    ->label('Jadikan Headline (Featured)')
                                    ->default(false),

                                Toggle::make('allow_comments')
                                    ->label('Izinkan Komentar')
                                    ->default(true),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
