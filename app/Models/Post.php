<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_post',
        'user_id',
        'parent_id'
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // In the Post model
    public function post_likes()
    {
        return $this->hasMany(LikePost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->morphMany(LikePost::class, 'likeable');
    }

    // In the Post model
    public function post_comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
