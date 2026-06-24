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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel sites
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            
            $table->string('name');
            $table->string('slug');
            
            $table->timestamps();

            // Unique Index: Satu website tidak boleh punya tag dengan slug yang sama
            $table->unique(['site_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};  