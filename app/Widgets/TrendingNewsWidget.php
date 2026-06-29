<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class TrendingNewsWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // 1. Ambil konfigurasi dari panel Admin Filament
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 5;
        $title = $config['title'] ?? 'Berita Populer';

        // 2. Ambil data berita, hitung jumlah view dari 7 hari terakhir
        $articles = Article::with(['category', 'media'])
            ->where('status', 'published')
            // Menjumlahkan kolom 'total_views' dari relasi dailyStats (7 hari terakhir)
            ->withSum(['dailyStats' => function ($query) {
                $query->where('stat_date', '>=', Carbon::now()->subDays(7));
            }], 'total_views')
            // Urutkan berdasarkan view terbanyak. Pakai COALESCE agar artikel dengan 0 view tetap tertangani
            ->orderByRaw('COALESCE(daily_stats_sum_total_views, 0) DESC')
            // Fallback: Jika ada artikel dengan jumlah view yang sama, urutkan berdasarkan yang paling baru
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