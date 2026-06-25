<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestArticlesWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
     protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Article::query()->latest()->limit(5))

            ->columns([
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->limit(50),

                BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'draft',
                        'success' => 'published',
                    ]),

                IconColumn::make('is_featured')
                    ->label('Pilihan')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime('d M Y H:i'),
            ])
            ->paginated(false);
    }
}
