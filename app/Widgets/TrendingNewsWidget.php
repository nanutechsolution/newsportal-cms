<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class TrendingNewsWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // 1. Ambil konfigurasi dari panel Admin Filament
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 5;
        $title = $config['title'] ?? 'Berita Populer';

        // 2. Ambil data dari database (Contoh: Berita terbaru yang di-publish)
        $articles = Article::with(['category', 'media'])
            ->where('status', 'published') // Sesuai enum ArticleStatus::Published
            ->latest('published_at')
            ->take($limit)
            ->get();

        // 3. Render ke dalam file blade khusus widget ini
        return View::make('widgets.trending-news', [
            'articles' => $articles,
            'title' => $title,
        ])->render();
    }
}