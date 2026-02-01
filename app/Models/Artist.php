<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_english',
        'name_nepali',
        'slug',
        'bio',
        'profile_image',
        'cover_image',
        'social_links',
        'is_verified',
        'views_count',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_verified' => 'boolean',
    ];

    // Automatically generate slug from English name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artist) {
            if (empty($artist->slug)) {
                $artist->slug = static::generateUniqueSlug($artist->name_english);
            }
        });
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    // Relationships
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    // Helper methods
    public function getTopSongs($limit = 10)
    {
        return $this->songs()
            ->where('is_published', true)
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
