<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_english',
        'title_nepali',
        'slug',
        'artist_id',
        'genre_id',
        'movie_id',
        'album_id',
        'year',
        'youtube_url',
        'views_count',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Auto-generate slug from English title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($song) {
            if (empty($song->slug)) {
                $song->slug = static::generateUniqueSlug($song->title_english);
            }

            // Auto-generate SEO meta if not provided
            if (empty($song->meta_title)) {
                $song->meta_title = $song->title_nepali . ' - ' . $song->title_english . ' Lyrics';
            }

            if (empty($song->meta_description)) {
                $song->meta_description = "Read and download {$song->title_nepali} ({$song->title_english}) lyrics in Nepali and Romanized format.";
            }
        });
    }

    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    // Relationships
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function lyric()
    {
        return $this->hasOne(Lyric::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Helper methods
    public function incrementViews($ipAddress, $userAgent)
    {
        $ipHash = hash('sha256', $ipAddress);
        $uaHash = hash('sha256', $userAgent);

        // Check if this IP viewed in last 24 hours
        $existing = $this->views()
            ->where('ip_hash', $ipHash)
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if (!$existing) {
            // Create view record
            $this->views()->create([
                'ip_hash' => $ipHash,
                'user_agent_hash' => $uaHash,
            ]);

            // Increment counter
            $this->increment('views_count');

            // Clear trending cache
            Cache::forget('trending_today');
            Cache::forget('trending_week');
            Cache::forget('trending_month');
        }
    }

    public function getRelatedSongs($limit = 5)
    {
        // Get songs by same artist, genre, or shared tags
        return static::where('id', '!=', $this->id)
            ->where('is_published', true)
            ->where(function ($query) {
                $query->where('artist_id', $this->artist_id)
                    ->orWhere('genre_id', $this->genre_id)
                    ->orWhereHas('tags', function ($q) {
                        $q->whereIn('tags.id', $this->tags->pluck('id'));
                    });
            })
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getMetaTitle()
    {
        return $this->meta_title ?: "{$this->title_nepali} - {$this->title_english} Lyrics | Nepali Lyrics";
    }

    public function getMetaDescription()
    {
        return $this->meta_description ?: "Read {$this->title_nepali} ({$this->title_english}) lyrics by {$this->artist->name_english}. Full Nepali and Romanized lyrics available.";
    }

    public function getCanonicalUrl()
    {
        return url("/lyrics/{$this->artist->slug}/{$this->slug}");
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeTrending($query, $period = 'week')
    {
        $date = match ($period) {
            'today' => now()->startOfDay(),
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            default => now()->subWeek(),
        };

        return $query->published()
            ->withCount([
                'views' => function ($q) use ($date) {
                    $q->where('created_at', '>=', $date);
                }
            ])
            ->orderBy('views_count', 'desc');
    }
}
