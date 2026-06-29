<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class HeadlineSliderWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // Mengambil konfigurasi limit (default 5 slide)
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 5;

        // Mengambil artikel khusus yang ditandai sebagai Featured (Headline Utama)
        $articles = Article::with(['category', 'author', 'media'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take($limit)
            ->get();

        return View::make('widgets.headline-slider', [
            'articles' => $articles,
            'widgetId' => $widget->id, // Untuk ID unik jika ada slider lain
        ])->render();
    }
}