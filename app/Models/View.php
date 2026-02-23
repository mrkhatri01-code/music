<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'song_id',
        'ip_hash',
        'user_agent_hash',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($view) {
            $view->created_at = now();
        });
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
