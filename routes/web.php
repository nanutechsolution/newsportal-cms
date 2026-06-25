<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Kita mengarahkan route utama ('/') ke HomeController yang baru dibuat
Route::get('/', [HomeController::class, 'index'])->name('home'); // Route untuk membaca detail artikel
// Route untuk melihat daftar berita per kategori
Route::get('/kategori/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
Route::get('/berita/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/halaman/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('page.show');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/penulis/{user}', [App\Http\Controllers\AuthorController::class, 'show'])->name('author.show');
