<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPostLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'group_id',
        'liked',
        'group_post_comment_id',
        'media_batch_number'
    ];

    public function groupPost()
    {
        return $this->belongsTo(GroupPost::class, 'post_id');
    }

    public function groupMedia()
    {
        return $this->belongsTo(GroupPost::class, 'media_batch_number');
    }

    public function comment()
    {
        return $this->belongsTo(GroupPostComments::class, 'group_post_comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
