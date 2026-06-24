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
        // Tabel agregasi harian untuk mempercepat query "Berita Terpopuler"
        Schema::create('article_daily_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            
            $table->date('stat_date');
            
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            
            // Opsional: Rata-rata waktu pembaca berada di halaman (detik)
            $table->unsignedInteger('avg_time_on_page')->default(0); 

            // Index super cepat untuk query "Terpopuler Hari Ini / Minggu Ini"
            $table->index(['site_id', 'stat_date', 'total_views']);
            
            // Mencegah duplikasi data statistik per artikel per hari
            $table->unique(['article_id', 'stat_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_daily_stats');
    }
};