<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPostComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'likes',
        'parent_id',
        'group_id',
        'media_batch_number',
    ];

    public function groupPost()
    {
        return $this->belongsTo(GroupPost::class, 'group_id');
    }

    public function replies()
    {
        return $this->hasMany(GroupPostComments::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(GroupPostCommentLike::class, 'comment_id');
    }
}
