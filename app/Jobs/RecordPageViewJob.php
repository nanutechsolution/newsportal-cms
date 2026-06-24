<?php

namespace App\Jobs;

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
        // Mencatat view secara asinkron agar loading halaman berita tetap < 100ms
        PageView::create([
            'site_id' => $this->siteId,
            'article_id' => $this->articleId,
            'session_id' => $this->sessionId,
            'view_date' => now()->toDateString(),
            'created_at' => now(),
        ]);
    }
}