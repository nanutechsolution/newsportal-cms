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
        // Item-item di dalam sebuah menu
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            
            // Self-referencing untuk sub-menu (dropdown)
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            
            $table->string('title');
            $table->string('url')->nullable();
            
            // Tipe item (apakah link custom, atau menaut ke halaman/kategori)
            $table->string('type')->default('custom_link'); 
            
            // Polymorphic untuk menautkan langsung ke Article/Category/Page
            $table->nullableMorphs('linkable');
            
            $table->string('target')->default('_self'); // '_blank', '_self'
            $table->string('icon_class')->nullable();
            $table->integer('order_column')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};