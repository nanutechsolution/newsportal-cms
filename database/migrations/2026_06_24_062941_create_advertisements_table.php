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
        // Tabel Manajemen Iklan Dinamis
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            
            $table->string('name');
            $table->string('type'); // 'adsense', 'custom_banner', 'video'
            $table->string('location'); // 'header', 'sidebar', 'in_article_1'
            
            // Script AdSense atau tag HTML <img> banner
            $table->text('code')->nullable();
            
            // Manajemen masa tayang iklan
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};