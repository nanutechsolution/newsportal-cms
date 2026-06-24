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
        // Tabel untuk halaman statis (Tentang Kami, Redaksi, dll) dan Homepage Builder
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable(); // Boleh null jika halaman ini murni kumpulan widget (Homepage)
            
            // Menentukan layout khusus, misal: 'default', 'full-width', 'homepage-builder'
            $table->string('layout')->default('default');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Unique index per website
            $table->unique(['site_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};