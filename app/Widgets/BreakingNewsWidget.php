<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class BreakingNewsWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // 1. Ambil konfigurasi limit & judul
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 3;
        $title = $config['title'] ?? 'BREAKING NEWS';

        // 2. Ambil artikel dengan status featured (Breaking News)
        $articles = Article::with(['category'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take($limit)
            ->get();

        // 3. Render ke view
        return View::make('widgets.breaking-news', [
            'articles' => $articles,
            'title' => $title,
        ])->render();
    }
}
