<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Agar tidak error saat edit

                TextInput::make('password')
                    ->password()
                    // Logika agar password otomatis di-hash sebelum disimpan
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    // Password hanya wajib diisi saat membuat user baru
                    ->required(fn(string $context): bool => $context === 'create')
                    // Jika saat edit password dikosongkan, jangan update kolom password
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255),

                // --- INPUT UNTUK SET ROLE (FILAMENT SHIELD) ---
                Select::make('roles')
                    ->label('Roles / Hak Akses')
                    ->relationship('roles', 'name') // Otomatis membaca tabel roles Spatie
                    ->multiple() // Hapus ini jika 1 user HANYA BOLEH punya 1 role
                    ->preload()  // Memuat data role di awal agar performa lancar
                    ->searchable() // Mempermudah pencarian jika role-nya banyak
                    ->required(),
            ]);
    }
}
