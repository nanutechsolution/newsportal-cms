<?php

namespace App\Widgets;

use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class BannerAdsWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // 1. Ambil konfigurasi link & gambar
        $config = $widget->configuration ?? [];
        $imageUrl = $config['image_url'] ?? '';
        $targetLink = $config['target_link'] ?? '#';

        // 2. Render ke view
        return View::make('widgets.banner-ads', [
            'imageUrl' => $imageUrl,
            'targetLink' => $targetLink,
        ])->render();
    }
}