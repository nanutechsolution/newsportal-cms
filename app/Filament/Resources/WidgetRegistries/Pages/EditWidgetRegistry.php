<?php

namespace App\Filament\Resources\WidgetRegistries\Pages;

use App\Filament\Resources\WidgetRegistries\WidgetRegistryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWidgetRegistry extends EditRecord
{
    protected static string $resource = WidgetRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
