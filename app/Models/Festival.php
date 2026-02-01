<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Festival extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($festival) {
            if (empty($festival->slug)) {
                $festival->slug = Str::slug($festival->name);
            }
        });
    }

    // Get songs tagged with this festival
    public function getSongs()
    {
        return Song::whereHas('tags', function ($query) {
            $query->where('slug', $this->slug);
        })->where('is_published', true)->get();
    }
}
