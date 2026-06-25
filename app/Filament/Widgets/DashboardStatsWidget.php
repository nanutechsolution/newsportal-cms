<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ArticleDailyStats;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        // 1. Hitung Artikel Terbit Hari Ini
        $publishedToday = Article::where('status', 'published')
            ->whereDate('published_at', Carbon::today())
            ->count();

        // 2. Hitung Total Views Hari Ini
        $viewsToday = ArticleDailyStats::whereDate('stat_date', Carbon::today())->sum('total_views') ?? 0;

        // 3. LOGIK PERBANDINGAN: Views Bulan Ini vs Bulan Lalu
        $viewsThisMonth = ArticleDailyStats::whereMonth('stat_date', Carbon::now()->month)
            ->whereYear('stat_date', Carbon::now()->year)
            ->sum('total_views') ?? 0;

        $viewsLastMonth = ArticleDailyStats::whereMonth('stat_date', Carbon::now()->subMonth()->month)
            ->whereYear('stat_date', Carbon::now()->subMonth()->year)
            ->sum('total_views') ?? 0;

        // Hitung persentase kenaikan/penurunan views
        if ($viewsLastMonth > 0) {
            $percentageChange = (($viewsThisMonth - $viewsLastMonth) / $viewsLastMonth) * 100;
            $viewTrendText = number_format(abs($percentageChange), 1) . '% ' . ($percentageChange >= 0 ? 'naik' : 'turun') . ' dari bulan lalu';
            $viewTrendIcon = $percentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
            $viewTrendColor = $percentageChange >= 0 ? 'success' : 'danger';
        } else {
            $viewTrendText = 'Belum ada data pembanding bulan lalu';
            $viewTrendIcon = 'heroicon-m-minus';
            $viewTrendColor = 'gray';
        }

        // 4. LOGIK PERBANDINGAN: Artikel Rilis Minggu Ini vs Minggu Lalu
        $articlesThisWeek = Article::where('status', 'published')
            ->whereBetween('published_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $articlesLastWeek = Article::where('status', 'published')
            ->whereBetween('published_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();

        $articleDiff = $articlesThisWeek - $articlesLastWeek;
        if ($articleDiff > 0) {
            $articleTrendText = "+{$articleDiff} artikel lebih banyak dari minggu lalu";
            $articleTrendIcon = 'heroicon-m-arrow-trending-up';
            $articleTrendColor = 'success';
        } elseif ($articleDiff < 0) {
            $articleTrendText = abs($articleDiff) . " artikel lebih sedikit dari minggu lalu";
            $articleTrendIcon = 'heroicon-m-arrow-trending-down';
            $articleTrendColor = 'danger';
        } else {
            $articleTrendText = 'Sama dengan jumlah minggu lalu';
            $articleTrendIcon = 'heroicon-m-minus';
            $articleTrendColor = 'gray';
        }


        // Return data ke komponen UI Filament
        return [
            // Stat 1: Artikel Baru Hari Ini
            Stat::make('Rilis Hari Ini', $publishedToday . ' Artikel')
                ->description('Artikel baru yang terbit hari ini')
                ->descriptionIcon('heroicon-m-document-plus')
                ->color('info'),

            // Stat 2: Views Hari Ini
            Stat::make('Views Hari Ini', number_format($viewsToday))
                ->description('Total klik artikel hari ini')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning'),

            // Stat 3: Tren Performa Views (Bulan Ini vs Bulan Lalu)
            Stat::make('Views Bulan Ini', number_format($viewsThisMonth))
                ->description($viewTrendText)
                ->descriptionIcon($viewTrendIcon)
                ->color($viewTrendColor),

            // Stat 4: Tren Produktivitas Jurnalis (Minggu Ini vs Minggu Lalu)
            Stat::make('Produktivitas Minggu Ini', $articlesThisWeek . ' Rilis')
                ->description($articleTrendText)
                ->descriptionIcon($articleTrendIcon)
                ->color($articleTrendColor),
        ];
    }
}
