<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_nepali');
            $table->string('slug')->unique();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('movie_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('album_id')->nullable()->constrained()->onDelete('set null');
            $table->year('year')->nullable();
            $table->string('youtube_url')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index('artist_id');
            $table->index('genre_id');
            $table->index('year');
            $table->index('views_count');
            $table->index('created_at');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
