<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('episode_number');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration')->default(0)->comment('seconds');
            $table->string('video_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_filler')->default(false);
            $table->date('aired_at')->nullable();
            $table->timestamps();

            $table->unique(['anime_id', 'episode_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
