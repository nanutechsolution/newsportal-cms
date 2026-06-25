<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class EditorsPickWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // Ambil berita yang di-flag khusus oleh editor
        $articles = Article::with(['author'])
            ->where('status', 'published')
            ->where('is_featured', true) // Asumsi flag featured/editor pick
            ->latest()
            ->take(3)
            ->get();

        return View::make('widgets.editors-pick', ['articles' => $articles])->render();
    }
}