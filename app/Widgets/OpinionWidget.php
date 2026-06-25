<?php

namespace App\Widgets;

use App\Models\Article;
use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class OpinionWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        // Query artikel khusus kategori 'Opini'
        $articles = Article::whereHas('category', fn($q) => $q->where('slug', 'opini'))
            ->where('status', 'published')
            ->latest()
            ->take(2)
            ->get();

        return View::make('widgets.opinion', ['articles' => $articles])->render();
    }
}