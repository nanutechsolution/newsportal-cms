<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class TrendingNewsWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 5;
        $title = $config['title'] ?? 'Berita Populer';

        // Menentukan rentang hari trending (contoh: dalam 7 hari terakhir)
        $trendingDays = $config['days'] ?? 7;
        $cutoffDate = now()->subDays($trendingDays)->toDateString();

        // 2. Ambil data berita dengan view terbanyak dalam rentang waktu tersebut
        $articles = Article::with(['category', 'media'])
            ->where('status', 'published')
            ->withSum(['dailyStats as total_clicks' => function ($query) use ($cutoffDate) {
                $query->where('stat_date', '>=', $cutoffDate);
            }], 'total_views')
            ->orderByDesc('total_clicks')
            ->take($limit)
            ->get();
        // 3. Render ke dalam file blade khusus widget ini
        return View::make('widgets.trending-news', [
            'articles' => $articles,
            'title' => $title,
        ])->render();
    }
}
