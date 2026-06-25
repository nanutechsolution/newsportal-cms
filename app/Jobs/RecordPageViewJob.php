<?php

namespace App\Jobs;

use App\Models\ArticleDailyStats;
use App\Models\PageView;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordPageViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $siteId;
    public $articleId;
    public $sessionId;
    public $ipAddress;

    public function __construct($siteId, $articleId, $sessionId, $ipAddress)
    {
        $this->siteId = $siteId;
        $this->articleId = $articleId;
        $this->sessionId = $sessionId;
        $this->ipAddress = $ipAddress;
    }

    public function handle(): void
    {
        $today = now()->toDateString();

        // 1. Cek dulu apakah session_id ini SUDAH PERNAH membaca artikel ini HARI INI.
        $isUniqueVisitor = !PageView::where('article_id', $this->articleId)
            ->where('session_id', $this->sessionId)
            ->where('view_date', $today)
            ->exists();

        // 2. Catat log mentah ke tabel page_views
        // Kita bungkus try-catch agar jika kebetulan ada user merefresh browser berkali-kali 
        // dalam milidetik yang sama (memicu duplikat database constraint), Job ini tidak ikut FAIL.
        try {
            PageView::create([
                'site_id' => $this->siteId,
                'article_id' => $this->articleId,
                'session_id' => $this->sessionId,
                'view_date' => $today,
            ]);
        } catch (\Exception $e) {
            // Abaikan jika log mentah gagal karena duplikat sesi di milidetik yang sama
        }

        // 3. CARA YANG BENAR DAN AMAN UNTUK MENGHITUNG VIEWS
        
        // Langkah A: Pastikan baris (row) untuk hari ini sudah terbuat. Jika belum, buat dengan nilai 0.
        $dailyStat = ArticleDailyStats::firstOrCreate(
            [
                'article_id' => $this->articleId,
                'stat_date' => $today,
            ],
            [
                'site_id' => $this->siteId,
                'total_views' => 0,
                'unique_visitors' => 0,
            ]
        );

        // Langkah B: Tambahkan angkanya menggunakan metode increment()
        // Metode ini otomatis menggunakan SQL UPDATE ... SET total_views = total_views + 1
        // yang 100% aman dari Race Condition tanpa memicu error Insert.
        $dailyStat->increment('total_views');
        
        if ($isUniqueVisitor) {
            $dailyStat->increment('unique_visitors');
        }
    }
}