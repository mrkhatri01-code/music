<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetRequest extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
