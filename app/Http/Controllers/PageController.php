<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        // Cari halaman berdasarkan slug, pastikan statusnya aktif, 
        // dan pastikan bukan halaman homepage-builder (karena itu untuk beranda)
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->where('layout', '!=', 'homepage-builder')
            ->firstOrFail();

        return view('page.show', compact('page'));
    }
}