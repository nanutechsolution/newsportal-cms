<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class LatestNewsWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 6;
        $title = $config['title'] ?? 'Berita Terbaru';

        // Mengambil berita terbaru yang sudah dipublikasi
        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take($limit)
            ->get();

        return View::make('widgets.latest-news', [
            'articles' => $articles,
            'title' => $title,
        ])->render();
    }
}