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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel sites
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            
            // Self-referencing foreign key untuk sub-kategori
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            
            // Konfigurasi tampilan kategori (opsional)
            $table->string('color_hex', 7)->nullable(); 
            $table->string('icon_class')->nullable();
            $table->integer('order_column')->default(0);
            
            $table->timestamps();

            // Unique Index: Satu website tidak boleh punya kategori dengan slug yang sama
            $table->unique(['site_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};