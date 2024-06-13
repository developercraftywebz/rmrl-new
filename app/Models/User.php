<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\UserRole;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use Khsing\World\Models\City;
use App\Helpers\Media;
use App\Models\Media as ModelsMedia;
use App\Models\UserCard;
use App\Models\UserDetail;
use App\Models\Payment;
use App\Models\UserComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
        'role_id',
        'country_id',
        'state_id',
        'city_id',
        'zip_code',
        'service_id',
        'otp',
        'contact_number',
        'profile_picture',
        'about_me',
        'gender',
        'date_of_birth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserDisplayFields()
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "status" => $this->status,
            "role_id" => $this->role_id,
            "role" => $this->Role ? $this->Role->name : null,
            "country_id" => $this->country_id,
            "country" => $this->Country ? $this->Country->name : null,
            "state_id" => $this->state_id,
            "state" => $this->State ? $this->State->name : null,
            "city_id" => $this->city_id,
            "city" => $this->City ? $this->City->name : null,
            "zip_code" => $this->zip_code,
            "otp" => $this->otp,
            "about_me" => $this->about_me,
            "gender" => $this->gender,
            "date_of_birth" => $this->date_of_birth,
            "contact_number" => $this->contact_number,
            "profile_picture" => Media::convertFullUrl($this->profile_picture),
            "created_at" => date('Y/m/d H:i:s', strtotime($this->created_at)),
            "comment" => $this->comments,
        ];
    }

    public function Role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function Country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function State()
    {
        return $this->belongsTo(Division::class, 'state_id', 'id');
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }



    public function Cards()
    {
        return $this->hasMany(UserCard::class);
    }

    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function UserDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function getCreatedAtForHumans()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function pollSubmissions()
    {
        return $this->hasMany(PollSubmission::class);
    }

    public function comments()
    {
        return $this->hasMany(UserComment::class);
    }

    public function commentReply()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function replyLikes()
    {
        return $this->hasMany(ReplyLike::class, 'user_id');
    }

    function adminProfileImage()
    {
        return $this->hasOne(AdminProfileImage::class);
    }

    public function user_comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'post_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'user_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_id');
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function poll()
    {
        return $this->hasMany(Poll::class, 'poll_id');
    }

    public function file()
    {
        return $this->hasMany(File::class, 'file_id');
    }

    public function gif()
    {
        return $this->hasMany(Gif::class, 'gif_id');
    }

    public function media()
    {
        return $this->hasMany(ModelsMedia::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function hasLiked(Comment $comment)
    {
        return $this->likes()->where('comment_id', $comment->id)->exists();
    }

    public function reply()
    {
        return $this->belongsTo(Comment::class, 'reply_id');
    }

    public function postLike()
    {
        return $this->hasMany(LikePost::class);
    }

    public function hasLikedPost(Post $post)
    {
        return $this->postLike()->where('likeable_id', $post->id)->where('likeable_type', Post::class)->exists();
    }

    public function hasLikedMedia(ModelsMedia $media)
    {
        return $this->postLike()->where('likeable_id', $media->batch_number)->where('likeable_type', ModelsMedia::class)->exists();
    }

    public function hasLikedPoll(Poll $poll)
    {
        return $this->postLike()->where('likeable_id', $poll->id)->where('likeable_type', Poll::class)->exists();
    }

    public function hasLikedFile(File $file)
    {
        return $this->postLike()->where('likeable_id', $file->id)->where('likeable_type', File::class)->exists();
    }

    public function hasLikedGif(Gif $gif)
    {
        return $this->postLike()->where('likeable_id', $gif->id)->where('likeable_type', Gif::class)->exists();
    }

    public function hasLikedGroup(Group $group)
    {
        return $this->postLike()->where('likeable_id', $group->id)->where('likeable_type', Group::class)->exists();
    }

    // Group related posts
    public function groupPosts()
    {
        return $this->hasMany(GroupPost::class, 'user_id');
    }

    public function likedGroupPosts()
    {
        return $this->hasMany(GroupPostLike::class, 'user_id')
            ->where('liked', true);
    }

    public function hasLikedGroupPost(GroupPost $post)
    {
        return $this->likedGroupPosts()
            ->where('group_id', $post->group_id)
            ->where('post_id', $post->id)
            ->exists();
    }

    public function hasLikedGroupMedia(GroupPost $post)
    {
        return $this->likedGroupPosts()
            ->where('media_batch_number', $post->media_batch_number)
            ->where('liked', true)
            ->exists();
    }

    public function groupLikes()
    {
        return $this->hasMany(GroupPostLike::class, 'post_id');
    }

    public function likedGroupComments()
    {
        return $this->hasMany(GroupPostCommentLike::class, 'user_id');
    }

    // Inside your User model
// Inside your User model
public function deleteImage()
{
    $oldImagePath = 'images/users/' . $this->profile_picture;

    if (Storage::exists($oldImagePath)) {
        Storage::delete($oldImagePath);
    }
}


}
