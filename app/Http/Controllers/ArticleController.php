<?php

namespace App\Http\Controllers;

use App\Jobs\RecordPageViewJob;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request, $slug)
    {
        // Mengambil artikel beserta relasi yang dibutuhkan
        $article = Article::with(['category', 'author', 'tags', 'media', 'seoMetadata'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Lempar proses pencatatan view ke Background Job (Queue)
        RecordPageViewJob::dispatch(
            $article->site_id,
            $article->id,
            $request->session()->getId(),
            $request->ip()
        );

        return view('article.show', compact('article'));
    }
}