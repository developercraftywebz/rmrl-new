<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_comment_id',
        'user_id',
        'reply',
    ];

    public function userComment()
    {
        return $this->belongsTo(UserComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyLikes()
    {
        return $this->hasMany(ReplyLike::class, 'reply_id');
    }
}
