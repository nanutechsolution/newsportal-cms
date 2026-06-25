<?php

namespace App\Filament\Resources\WidgetRegistries;

use App\Filament\Resources\WidgetRegistries\Pages\CreateWidgetRegistry;
use App\Filament\Resources\WidgetRegistries\Pages\EditWidgetRegistry;
use App\Filament\Resources\WidgetRegistries\Pages\ListWidgetRegistries;
use App\Filament\Resources\WidgetRegistries\Schemas\WidgetRegistryForm;
use App\Filament\Resources\WidgetRegistries\Tables\WidgetRegistriesTable;
use App\Models\WidgetRegistry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WidgetRegistryResource extends Resource
{
    protected static ?string $model = WidgetRegistry::class;


    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static string|UnitEnum|null $navigationGroup = 'Sistem & Pengaturan';
    protected static ?string $navigationLabel = 'Registri Widget';
    protected static ?int $navigationSort = 5;


    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return WidgetRegistryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WidgetRegistriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWidgetRegistries::route('/'),
            'create' => CreateWidgetRegistry::route('/create'),
            'edit' => EditWidgetRegistry::route('/{record}/edit'),
        ];
    }
}
