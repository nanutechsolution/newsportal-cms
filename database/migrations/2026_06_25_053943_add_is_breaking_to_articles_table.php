<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('is_breaking')->default(false)->after('is_featured');
            $table->string('cover_caption')->nullable()->after('content');
            $table->string('cover_source')->nullable()->after('cover_caption');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('is_breaking');
            $table->dropColumn('cover_caption');
            $table->dropColumn('cover_source');
        });
    }
};
