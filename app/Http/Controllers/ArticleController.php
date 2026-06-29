<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PageView;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request, $slug)
    {
        // 1. Mengambil artikel beserta relasi yang dibutuhkan
        $article = Article::with(['category', 'author', 'tags', 'media', 'seoMetadata'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // 2. Mencatat view secara langsung (Tanpa Queue)
        // Solusi aman untuk Shared Hosting yang tidak mendukung Supervisor/Redis
        PageView::create([
            'site_id' => $article->site_id,
            'article_id' => $article->id,
            'session_id' => $request->session()->getId(),
            'view_date' => now()->toDateString(),
            'created_at' => now(),
        ]);

        // 3. Tampilkan halaman detail artikel
        return view('article.show', compact('article'));
    }
}