<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Komentar')
                    ->schema([
                        TextInput::make('guest_name')
                            ->label('Nama Pengirim')
                            ->disabled(),
                        TextInput::make('guest_email')
                            ->label('Email')
                            ->disabled(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'spam' => 'Spam',
                            ])
                            ->required(),
                        Textarea::make('body')
                            ->label('Isi Komentar')
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
