<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug)
    {
        // Mencari Tag berdasarkan slug
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // Mengambil artikel-artikel yang memiliki relasi dengan Tag ini
        // Hanya yang berstatus 'published'
        $articles = $tag->articles()
            ->with(['author', 'category', 'media'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('tag.show', compact('tag', 'articles'));
    }
}