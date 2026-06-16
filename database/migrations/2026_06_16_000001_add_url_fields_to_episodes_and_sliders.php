<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('thumbnail_url')->nullable()->after('thumbnail');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('thumbnail_url');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
