<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PENTING: Karena kita akan menggunakan MySQL Partitioning berbasis RANGE COLUMNS(view_date),
        // tabel tidak boleh memiliki Primary Key 'id' yang auto_increment jika 'id' tersebut bukan bagian dari partisi.
        // Selain itu, MySQL Partitioning TIDAK MENDUKUNG Foreign Key. 
        // Jadi kita gunakan unsignedBigInteger biasa dan mendelegasikan integritas data ke level aplikasi/Eloquent.

        Schema::create('page_views', function (Blueprint $table) {
            $table->unsignedBigInteger('id'); 
            
            // Mengganti foreignId()->constrained() menjadi unsignedBigInteger biasa dengan index manual
            $table->unsignedBigInteger('site_id')->index();
            $table->unsignedBigInteger('article_id');
            
            // Relasi ke session_tracking
            $table->string('session_id')->nullable()->index();
            
            $table->date('view_date');
            $table->timestamp('created_at')->useCurrent();
            
            // Composite Primary Key wajib untuk Partitioning (mengikutkan view_date)
            $table->primary(['id', 'view_date']);
            
            // Index untuk mempercepat rekap harian
            $table->index(['article_id', 'view_date']);
        });

        // Menambahkan AUTO_INCREMENT ke kolom ID secara manual setelah Composite PK dibuat
        DB::statement('ALTER TABLE page_views MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        // --- IMPLEMENTASI MYSQL PARTITIONING ---
        // Membuat partisi berdasarkan RANGE kolom view_date (Bulanan)
        DB::statement("
            ALTER TABLE page_views PARTITION BY RANGE COLUMNS(view_date) (
                PARTITION p_2026_06 VALUES LESS THAN ('2026-07-01'),
                PARTITION p_2026_07 VALUES LESS THAN ('2026-08-01'),
                PARTITION p_2026_08 VALUES LESS THAN ('2026-09-01'),
                PARTITION p_2026_09 VALUES LESS THAN ('2026-10-01'),
                PARTITION p_2026_10 VALUES LESS THAN ('2026-11-01'),
                PARTITION p_2026_11 VALUES LESS THAN ('2026-12-01'),
                PARTITION p_2026_12 VALUES LESS THAN ('2027-01-01'),
                PARTITION p_max VALUES LESS THAN MAXVALUE
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};