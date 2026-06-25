<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $article = Article::findOrFail($articleId);

        // Validasi input pembaca
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'comment.required' => 'Isi komentar tidak boleh kosong.',
            'comment.min' => 'Komentar minimal berisi 5 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Simpan komentar pembaca ke database (status awal is_approved = false)
        Comment::create([
            'article_id' => $article->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'name' => strip_tags($request->name),
            'email' => strip_tags($request->email),
            'comment' => strip_tags($request->comment),
            'ip_address' => $request->ip(),
            'is_approved' => false, // Menunggu persetujuan editor/admin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar Anda berhasil dikirim dan sedang menunggu moderasi redaksi.'
        ]);
    }
}
