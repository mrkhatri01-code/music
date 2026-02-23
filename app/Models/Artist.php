<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_english',
        'name_nepali',
        'type',
        'slug',
        'bio',
        'date_of_birth',
        'profile_image',
        'cover_image',
        'social_links',
        'is_verified',
        'views_count',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_verified' => 'boolean',
        'date_of_birth' => 'date',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function writtenSongs()
    {
        return $this->hasMany(Song::class, 'writer_id');
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

    // Accessors
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return null;
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return null;
    }

    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }
}
