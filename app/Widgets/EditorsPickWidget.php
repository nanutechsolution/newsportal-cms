<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class EditorsPickWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        $config = $widget->configuration ?? [];
        $limit = $config['limit'] ?? 4; // Ambil 4 berita untuk mengisi 1 Hero dan 3 List

        // Logika Kurasi Redaksi: Hanya ambil yang di-flag "is_editors_pick"
        $articles = Article::with(['category', 'author', 'media'])
            ->where('status', 'published')
            ->where('is_editors_pick', true)
            ->latest('published_at') // Urutkan yang terbaru di antara pilihan editor
            ->take($limit)
            ->get();

        return View::make('widgets.editors-pick', [
            'articles' => $articles,
        ])->render();
    }
}