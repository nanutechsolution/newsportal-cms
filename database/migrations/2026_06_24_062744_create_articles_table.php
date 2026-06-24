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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            
            // Relasi Utama
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            
            // Relasi User (Penulis & Editor)
            // Menggunakan set null jika user dihapus agar artikel tetap ada sebagai arsip
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Konten Inti
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            // Workflow Status (Menggunakan String yang nanti dipetakan ke Enum di Model)
            // Nilai: draft, review, revision, approved, scheduled, published, archived, rejected
            $table->string('status')->default('draft');
            
            // Pengaturan Artikel
            $table->boolean('is_featured')->default(false); // Untuk Breaking/Headline
            $table->boolean('allow_comments')->default(true);
            
            // Timestamps Khusus
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Fitur tong sampah sebelum dihapus permanen

            // --- INDEXING STRATEGY (Sangat Penting untuk Skala Besar) ---
            
            // 1. Unique index per website
            $table->unique(['site_id', 'slug']);
            
            // 2. Composite Index untuk Query Berita Terbaru (Sering dipanggil di Frontend)
            $table->index(['site_id', 'status', 'published_at']);
            
            // 3. Index untuk kategori (Sering difilter di Frontend)
            $table->index(['category_id', 'status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};