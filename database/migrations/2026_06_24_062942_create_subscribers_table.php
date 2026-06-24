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
        // Tabel Newsletter Subscribers
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            
            $table->string('email');
            $table->boolean('is_active')->default(true);
            $table->dateTime('verified_at')->nullable();
            
            $table->timestamps();

            // Satu email hanya bisa subsribe satu kali per website
            $table->unique(['site_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};