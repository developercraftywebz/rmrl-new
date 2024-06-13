<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'file_type',
        'category_id',
        'user_id',
        'batch_number',
        'media_caption'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->hasMany(MediaLike::class, 'media_id');
    }

    public function userComments()
    {
        return $this->hasMany(UserComment::class, 'media_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function like()
    {
        return $this->morphMany(LikePost::class, 'likeable');
    }
}
