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
        // Tabel Polymorphic untuk melampirkan SEO ke berbagai entitas (Article, Category, Page)
        Schema::create('seo_metadata', function (Blueprint $table) {
            $table->id();
            
            // Kolom model_type (misal: App\Models\Article) dan model_id
            $table->morphs('model'); 
            
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image_url')->nullable();
            
            // Untuk menyimpan schema.org JSON-LD (NewsArticle, Organization, dll)
            $table->json('schema_json')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metadata');
    }
};