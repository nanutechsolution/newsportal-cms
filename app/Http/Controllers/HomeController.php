<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Halaman dengan slug 'home' beserta relasi widget-nya
        // Pastikan Page dengan slug 'home' sudah terbuat oleh Seeder
        $page = Page::with(['widgets.registry'])->where('slug', 'home')->first();

        // Jika halaman tidak ditemukan, tampilkan 404
        if (!$page) {
            abort(404, 'Homepage belum dikonfigurasi. Silakan jalankan seeder atau buat Page dengan slug "home".');
        }

        return view('home', compact('page'));
    }
}