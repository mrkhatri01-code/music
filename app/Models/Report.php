<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_id',
        'type',
        'description',
        'status',
        'claimant_name',
        'claimant_email',
        'claimant_phone',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
