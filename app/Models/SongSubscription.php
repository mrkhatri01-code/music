<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongSubscription extends Model
{
    protected $fillable = [
        'song_id',
        'email',
        'status',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
