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
        // Antrean sinkronisasi Meilisearch asinkron untuk mencegah timeout saat mass publish
        Schema::create('search_index_queue', function (Blueprint $table) {
            $table->id();
            
            $table->string('model_type'); // App\Models\Article
            $table->unsignedBigInteger('model_id');
            
            $table->string('action'); // 'index', 'delete'
            $table->string('status')->default('pending'); // 'pending', 'processing', 'failed', 'done'
            
            $table->unsignedInteger('attempts')->default(0);
            
            $table->timestamps();

            // Index untuk kecepatan worker mencari data yang pending
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_index_queue');
    }
};  