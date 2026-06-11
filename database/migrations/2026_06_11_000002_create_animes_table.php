<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->year('release_year')->nullable();
            $table->enum('status', ['ongoing', 'completed', 'upcoming'])->default('ongoing');
            $table->unsignedSmallInteger('total_episodes')->default(0);
            $table->unsignedSmallInteger('episode_duration')->default(24)->comment('minutes per episode');
            $table->decimal('avg_rating', 3, 1)->default(0.0);
            $table->unsignedBigInteger('votes_count')->default(0);
            $table->string('studio')->nullable();
            $table->string('director')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('trailer_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
