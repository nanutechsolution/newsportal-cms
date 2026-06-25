<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IndeksController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal adalah hari ini, atau sesuai input filter tanggal
        $dateInput = $request->input('tanggal', Carbon::today()->toDateString());

        $articles = Article::with(['category', 'media'])
            ->where('status', 'published')
            ->whereDate('published_at', $dateInput)
            ->latest('published_at')
            ->paginate(20);

        return view('indeks.index', [
            'articles' => $articles,
            'selectedDate' => $dateInput,
        ]);
    }
}
