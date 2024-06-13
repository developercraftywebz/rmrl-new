<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'group_description',
        'privacy_type',
        'user_id',
        'user_count',
        'group_photo',
        'group_cover_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(LikePost::class, 'likeable');
    }

    public function userGroups()
    {
        return $this->hasMany(UserGroup::class, 'group_id');
    }
}
