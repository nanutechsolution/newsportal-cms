<?php

namespace App\Filament\Resources\WidgetRegistries\Pages;

use App\Filament\Resources\WidgetRegistries\WidgetRegistryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWidgetRegistries extends ListRecords
{
    protected static string $resource = WidgetRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
