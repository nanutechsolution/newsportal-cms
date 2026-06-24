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
        Schema::create('session_tracking', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel sites
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
            
            $table->string('session_id')->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('device_type', 50)->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamp('last_activity');
            $table->timestamps();

            // Composite Index B-Tree untuk kecepatan pencarian unique visitor
            $table->index(['session_id', 'last_activity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_tracking');
    }
};