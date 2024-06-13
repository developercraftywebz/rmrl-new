<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_id',
        'is_liked',
        'user_id',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
