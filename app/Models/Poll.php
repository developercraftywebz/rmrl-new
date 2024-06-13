<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'options',
        'allow_multiple',
        'user_id',
    ];

    protected $casts = [
        'options' => 'json',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function pollSubmissions()
    {
        return $this->hasMany(PollSubmission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->morphMany(LikePost::class, 'likeable');
    }
}
