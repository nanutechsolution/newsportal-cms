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
        Schema::create('widget_registry', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: Trending News Widget
            $table->string('class_name')->unique(); // contoh: App\Widgets\TrendingNewsWidget
            $table->json('default_config_schema')->nullable(); // Struktur default konfigurasi widget
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_registry');
    }
};