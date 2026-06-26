<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        // 1. Validasi Inputan
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'body' => 'required|string|max:1000',
        ]);

        // 2. Simpan ke database menggunakan relasi
        $article->comments()->create([
            // Jika Anda sudah punya sistem login user, bisa gunakan auth()->id() di sini
            'user_id' => null, 
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'body' => $request->body,
            'status' => 'approved', // Langsung tayang. Ubah ke 'pending' jika butuh moderasi
        ]);

        // 3. Kembalikan ke halaman artikel dengan pesan sukses
        return back()->with('success', 'Terima kasih! Komentar Anda berhasil diterbitkan.');
    }
}