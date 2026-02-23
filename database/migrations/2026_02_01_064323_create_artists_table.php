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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name_english');
            $table->string('name_nepali');
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('social_links')->nullable(); // {youtube, facebook, instagram, tiktok, spotify, apple_music, website}
            $table->boolean('is_verified')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
