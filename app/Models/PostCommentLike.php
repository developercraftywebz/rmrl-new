<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentLike extends Model
{

    use HasFactory;
    protected $fillable = ['comment_id', 'user_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(PostComment::class);
    }
}
