<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk menyimpan sejarah versi artikel
        Schema::create('article_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Menyimpan seluruh payload artikel lama (bisa JSON atau Text)
            // Di sini kita simpan sebagai JSON agar lebih mudah melacak perubahan per kolom
            $table->json('payload');
            
            // Catatan perubahan dari editor (misal: "Memperbaiki salah ketik di paragraf 2")
            $table->string('revision_note')->nullable();
            
            $table->timestamps(); // created_at adalah waktu revisi disimpan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_revisions');
    }
};