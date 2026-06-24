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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('type_name')->unique(); // contoh: article_published, article_rejected
            $table->string('subject');
            $table->text('body_template');
            $table->json('available_variables')->nullable(); // contoh: ["article_title", "author_name"]
            $table->json('channels')->nullable(); // contoh: ["mail", "database"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};