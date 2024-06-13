<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class PostComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use NodeTrait;

    protected $fillable = [
        'message', 
        'status', 
        'post_id', 
        'user_id', 
        'parent_id', 

    ];

    protected $table = 'post_comments';

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    public function users(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
       public function getLikeCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getDislikeCountAttribute()
    {
        return $this->dislikes()->count();
    }

    public function likes(){ 
        return $this->hasMany(CommentLike::class,'comment_id','id')->where('type','like');
    }

    public function dislikes(){ 
        return $this->hasMany(CommentLike::class,'comment_id','id')->where('type','dislike');
    }

    public function allCommentReplies()
    {
        // when visiting the url where i'm 3 levels deep, i'm getting the right category, but as you see:
        print_r($this->isRoot());  // returns: 1       
        print_r($this->ancestors()->get()->toTree()); // returns: Kalnoy\Nestedset\Collection Object ( [items:protected] => Array ( ) )
        // it doesn't seem to recognise the nestedset system

        $ancestors         = ($this->isRoot()) ? NULL : $this->ancestors()->get();

        $categoryCollection   = (empty($ancestors)) ? self::with('CommentReplies') ->find($this->id): $ancestors->toTree()->with('CommentReplies');

        return $categoryCollection;
    }
}
