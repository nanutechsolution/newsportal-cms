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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            
            // User yang komentar (jika wajib login)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Data tamu (jika komentar tanpa login diizinkan)
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            
            // Self-referencing untuk balasan komentar (nested/replies)
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            
            $table->text('body');
            
            // Status Moderasi: pending, approved, spam, rejected
            $table->string('status')->default('pending');
            
            $table->timestamps();

            // Indexing untuk mempercepat loading komentar di Frontend
            $table->index(['article_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};