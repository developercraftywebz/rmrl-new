<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_image',
        'cover_image',
        'user_id',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
