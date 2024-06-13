<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'type', 'parent_id', 'user_id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'comment_id');
    }

    public function replyLikes()
    {
        return $this->hasMany(Like::class, 'reply_id');
    }

    // Accessor to get the like count attribute
    public function getLikeCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getReplyLikeCount()
    {
        return $this->replyLikes()->count();
    }

    // Method to get the like count for a specific comment instance
    public function getLikeCount()
    {
        return $this->getLikeCountAttribute();
    }
}
