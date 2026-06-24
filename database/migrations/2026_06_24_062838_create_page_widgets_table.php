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
        // Tabel Pivot untuk menempelkan Widget ke sebuah Halaman (Homepage Builder)
        Schema::create('page_widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->foreignId('widget_registry_id')->constrained('widget_registry')->cascadeOnDelete();
            
            // Konfigurasi spesifik widget ini (misal: tampilkan 5 berita kategori X)
            $table->json('configuration')->nullable(); 
            
            // Urutan penempatan widget di halaman
            $table->integer('order_column')->default(0); 
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_widgets');
    }
};