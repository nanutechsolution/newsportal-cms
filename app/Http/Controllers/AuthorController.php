<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        // Memuat artikel yang ditulis oleh penulis ini
        $articles = $user->articles()->where('status', 'published')->latest()->paginate(10);
        
        return view('author.show', compact('user', 'articles'));
    }
}