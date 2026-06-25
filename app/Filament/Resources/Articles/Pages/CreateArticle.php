<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
    /**
     * getRedirectUrl
     *
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
