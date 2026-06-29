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
            // ALGORITMA GRAVITASI BERITA (HOTNESS RANK):
            // (Jumlah Views) dibagi dengan (Umur Artikel dalam Jam + 2) pangkat 1.5
            // Semakin lama artikel, skornya akan semakin anjlok, memberi ruang untuk berita baru.
            ->orderByRaw('(COALESCE(daily_stats_sum_total_views, 0) / POW(TIMESTAMPDIFF(HOUR, published_at, NOW()) + 2, 1.5)) DESC')
            // Fallback: Jika ada artikel dengan skor yang sama persis
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