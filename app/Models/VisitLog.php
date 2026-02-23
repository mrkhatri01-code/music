<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'url',
        'referral',
        'user_agent',
        'user_id',
        'location_data',
    ];

    protected $casts = [
        'location_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
