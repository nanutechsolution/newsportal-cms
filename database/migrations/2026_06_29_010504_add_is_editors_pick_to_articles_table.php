<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Menambahkan kolom boolean setelah is_featured
            $table->boolean('is_editors_pick')->default(false)->after('is_featured');
            
            // Tambahkan index agar pencarian widget ini sangat cepat
            $table->index(['is_editors_pick', 'status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['is_editors_pick', 'status', 'published_at']);
            $table->dropColumn('is_editors_pick');
        });
    }
};