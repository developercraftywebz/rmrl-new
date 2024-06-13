<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'text_post',
        'media_url',
        'poll_options',
        'file_path',
        'gif_url',
        'likes',
        'group_id',
        'file_details',
        'file_name',
        'media_batch_number',
    ];

    public function groupPostComment()
    {
        return $this->hasMany(GroupPostComments::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function likesCount()
    {
        return $this->likers()->count();
    }

    public function isLikedByUser(User $user)
    {
        return $this->likers()->where('user_id', $user->id)->exists();
    }

    public function groupPostLikes()
    {
        return $this->hasMany(GroupPostLike::class, 'post_id');
    }

    public function groupLikes()
    {
        return $this->hasMany(GroupPostCommentLike::class, 'post_id');
    }

    public function hasLikedGroupComment(GroupPostComments $group_comment)
    {
        return $this->groupLikes()->where('comment_id', $group_comment->id)->exists();
    }
}
