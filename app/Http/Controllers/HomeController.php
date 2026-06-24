<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 4 berita headline (is_featured = true) yang sudah diterbitkan
        $featuredArticles = Article::with(['category', 'media'])
            ->where('is_featured', true)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        // Mengambil 10 berita terbaru biasa
        $latestArticles = Article::with(['category', 'media'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(10)
            ->get();

        return view('home', compact('featuredArticles', 'latestArticles'));
    }
}