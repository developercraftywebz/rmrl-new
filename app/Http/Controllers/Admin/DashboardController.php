<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypes;
use App\Helpers\Media;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\File;
use App\Models\Gif;
use App\Models\Group;
use App\Models\GroupPost;
use App\Models\GroupPostCommentLike;
use App\Models\GroupPostComments;
use App\Models\GroupPostLike;
use App\Models\Like;
use App\Models\LikePost;
use App\Models\Media as ModelsMedia;
use App\Models\Poll;
use App\Models\PollSubmission;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.dashboard.index', compact('categories'));
    }

    public function category(Request $request, $category_id = null)
    {
        $option = $request->input('option', 'photos');
        $latestImages = [];
        $responseData = [];
        $streamPostMedia = []; // Initialize an array to store media with category_id = 0
        $media = ModelsMedia::where('file_type', 'Image')->orderBy('created_at', 'desc')->get();

        if ($option === 'albums') {
            // Get the latest image from each album (category)
            $categories = Category::with('media')->get();

            foreach ($categories as $cat) {
                $latestImage = $cat->media()->where('file_type', 'Image')->latest('created_at')->first();
                $categoryData = [
                    'category_id' => $cat,
                    // 'media' => $cat->media()->where('file_type', 'Image')->get(),
                ];
                $responseData[] = $categoryData;
                $latestImages[$cat->id] = $latestImage;
            }

            // Check if a specific category ID is provided
            if ($category_id) {
                $category = Category::with('media')->find($category_id);
                $categoryImages = $category->media()->where('file_type', 'Image')->get();
                return response()->json(compact('categoryImages', 'category', 'latestImages', 'option'), 200);
            }

            // Collect media items with category_id = 0
            $streamPostMedia = $media->where('category_id', 0)->all();
        }

        // Return JSON response for the default option
        $responseData[] = [
            'category_id' => null,
            'media' => $media,
        ];

        if ($request->expectsJson()) {
            return response()->json(compact('responseData', 'latestImages', 'option', 'streamPostMedia'), 200);
        } else {
            return view('admin.category.index', compact('media', 'latestImages', 'option', 'streamPostMedia'));
        }
    }

    public function categoryImages($category_id)
    {
        $category = Category::findOrFail($category_id);
        $categoryImages = $category->media()->where('file_type', 'Image')->get();
        return view('admin.category.view', compact('category', 'categoryImages'));
    }

    public function storeCategory(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'album_name' => 'required|unique:categories',
            'files' => 'array',
            'files.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,bmp,webp,tiff,svg,svgz,tif,mp4,avi,wmv,mov,mkv,flv,3gp,mpeg,mpg|max:2048',
        ]);
        $category = Category::create([
            'album_name' => $request->input('album_name'),
            'album_description' => $request->input('album_description'),
            'user_id' => $user->id,
        ]);

        // Check if there are images
        if ($request->hasFile('files') && count($request->file('files')) > 0) {
            $uploadedMedia = [];
            foreach ($request->file('files') as $file) {
                // Get the uploaded file
                $extension = $file->getClientOriginalExtension();
                $type = in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'svgz', 'tif']) ? 'Image' : 'Video';

                // Upload and process each file
                $media = Media::convertFullUrl(Media::uploadMedia($file));
                ModelsMedia::create([
                    'file_path' => $media,
                    'file_type' => $type,
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                ]);
                $uploadedMedia[] = $media;
            }
        }
        return redirect()->route('home')->with('success', 'Album created successfully.');
    }


















    public function storeMedia(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpeg,jpg,png,gif,bmp,webp,tiff,svg,svgz,tif,mp4,avi,wmv,mov,mkv,flv,3gp,mpeg,mpg',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $uploadedMedia = [];
        $currentBatchNumber = ModelsMedia::where('user_id', auth()->user()->id)->max('batch_number') + 1;
        foreach ($request->file('files') as $file) {
            // Get the uploaded file
            $extension = $file->getClientOriginalExtension();
            $type = in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'svgz', 'tif']) ? 'Image' : 'Video';
            $media = Media::convertFullUrl(Media::uploadMedia($file));

            ModelsMedia::create([
                'file_path' => $media,
                'file_type' => $type,
                'category_id' => $request->category_id ?? 0,
                'user_id' => auth()->user()->id,
                'batch_number' => $currentBatchNumber,
                'media_caption' => $request->media_caption,
            ]);
            $uploadedMedia[] = $media;
        }
        return redirect()->route('home')->with('success', 'Media uploaded successfully.');
    }












    public function storeGif(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);
        Gif::create([
            'url' => $request->input('url'),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('home')->with('success', 'GIF stored successfully!');
    }

    public function storePoll(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'options' => ['array', 'min:2'],
            'options.*' => ['nullable', 'string', 'max:255'],
            'allow_multiple' => 'nullable|in:0,1',
        ]);
        Poll::create([
            'question' => $request->input('question'),
            'options' => $request->input('options'),
            'allow_multiple' => $request->input('allow_multiple'),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('home')->with('success', 'Poll has been created successfully');
    }

    public function submitPoll(Request $request)
    {
        $pollId = $request->input('pollId');
        $user = Auth::user();
        if ($user->pollSubmissions->contains('poll_id', $pollId)) {
            return back()->with('error', 'You have already submitted this poll.');
        }
        $poll = Poll::find($pollId);
        if (!$poll) {
            return back()->with('error', 'Poll not found.');
        }
        $selectedOptions = $request->input("poll_option_$pollId");
        if ($poll->allow_multiple) {
            $validatedOptions = collect($selectedOptions)->filter(function ($option) {
                return !empty($option);
            })->values()->all();
        } else {
            $validatedOptions = !empty($selectedOptions) ? [$selectedOptions] : [];
        }
        $answer = PollSubmission::create([
            'poll_id' => $pollId,
            'user_id' => $user->id,
            'selected_options' => json_encode($validatedOptions),
        ]);
        return back()->with('success', 'Poll submitted successfully.');
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'blog_post' => 'required|string',
        ]);
        Post::create([
            'blog_post' => $request->input('blog_post'),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('home')->with('success', 'Blog posted successfully');
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,csv,txt,rtf,ppt,pptx',
            'file_details' => 'required|string',
        ]);

        $directory = 'uploads';
        if (!File::exists($directory)) {
            FacadesFile::makeDirectory($directory, 0777, true, true);
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $fileCovert = Media::convertFullUrl(Media::fileUpload($file));
            File::create([
                'file' => $fileCovert,
                'file_details' => $request->input('file_details'),
                'file_name' => $file_name,
                'user_id' => auth()->user()->id,
            ]);

            return redirect()->route('home')->with('success', 'File uploaded successfully');
        } else {
            return redirect()->route('home')->with('error', 'File upload failed');
        }
    }

    public function addComment(Request $request, $commentableType, $commentableId)
    {
        $user = Auth::user();
        $request->validate([
            'content' => 'required|string',
            'type' => 'required', // Validate the comment type
        ]);
        $commentable = null;
        switch ($commentableType) {
            case 'post':
                $commentable = Post::find($commentableId);
                break;
            case 'poll':
                $commentable = Poll::find($commentableId);
                break;
            case 'file':
                $commentable = File::find($commentableId);
                break;
            case 'gif':
                $commentable = Gif::find($commentableId);
                break;
            case 'media':
                $commentable = ModelsMedia::find($commentableId);
                break;
            case 'group':
                $commentable = Group::find($commentableId);
                break;
            default:
                return back()->redirect()->route('home')->with('error', 'Invalid commentable type.');
        }

        if (!$commentable) {
            return back()->with('error', 'Commentable not found.');
        }

        if ($user->role_id == 1) {
            $subscription = Subscription::where('user_id', $user->id)->first();
            // if (!$subscription && UserTypes::User && $user->feature_count > 4) {
            //     return redirect()->back()->with('flash_error', 'Please subscribe for full features.');
            // }
        }

        // Create and save the comment
        $comment = new Comment([
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'user_id' => $user->id
        ]);
        $commentable->comments()->save($comment);
        // if ($user->role_id == UserTypes::User) {
        //     $user->feature_count -= 1;
        //     $user->save();
        // }
        return back()->with('success', 'Comment added successfully.');
    }

    public function commentReplies(Request $request, $commentId)
    {
        $user = Auth::user();
        $request->validate([
            'content' => 'required|string',
            'type' => 'required',
        ]);

        $parentComment = Comment::find($commentId);
        if (!$parentComment) {
            return back()->with('error', 'Comment not found.');
        }

        // Create and save the reply
        $reply = new Comment([
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'parent_id' => $commentId,
            'user_id' => $user->id
        ]);
        $parentComment->replies()->save($reply);
        // Deduct 1 from feature_count
        // if ($user->role_id == UserTypes::User) {
        //     $user->feature_count -= 1;
        //     $user->save();
        // }
        return redirect()->route('home')->with('success', 'Reply added successfully.');
    }

    public function editComment(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = auth()->user();

        // Check if the user has permission to edit the comment
        if (
            ($user->role_id == UserTypes::User && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Admin)
        ) {
            $comment->update([
                'content' => $request->input('content'),
            ]);
            return redirect()->route('home', ['commentId' => $commentId])->with('flash_success', 'Comment updated successfully.');
        } else {
            return back()->with('flash_error', 'You do not have permission to edit this comment.');
        }
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = auth()->user();
        if (
            ($user->role_id == UserTypes::User && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $comment->user_id === $user->id)
        ) {
            // Delete logic for end users or moderators
            $comment->delete();
            return back()->with('flash_success', 'Comment deleted successfully.');
        } elseif ($user->role_id == UserTypes::Admin) {
            // Delete logic for admin
            $comment->delete();
            return back()->with('flash_success', 'Comment deleted successfully.');
        } else {
            return back()->with('flash_error', 'You do not have permission to delete this comment.');
        }
    }

    public function editReply(Request $request, $replyId)
    {
        $reply = Comment::findOrFail($replyId);
        $user = auth()->user();
        if (
            ($user->role_id == UserTypes::User && $reply->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $reply->user_id === $user->id)
        ) {
            $reply->update([
                'content' => $request->input('content'),
            ]);
            return back()->with('flash_success', 'Reply updated successfully.');
        } elseif ($user->role_id == UserTypes::Admin) {
            $reply->update([
                'content' => $request->input('content'),
            ]);
            // Deduct 1 from feature_count
            // if ($user->role_id == UserTypes::User) {
            //     $user->feature_count -= 1;
            //     $user->save();
            // }
            return back()->with('flash_success', 'Reply updated successfully.');
        } else {
            return back()->with('flash_error', 'You do not have permission to update this reply.');
        }
    }

    public function deleteReply($replyId)
    {
        $comment = Comment::findOrFail($replyId);
        $user = auth()->user();
        if (
            ($user->role_id == UserTypes::User && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $comment->user_id === $user->id)
        ) {
            // Delete logic for end users or moderators
            $comment->delete();
            return back()->with('flash_success', 'Reply deleted successfully.');
        } elseif ($user->role_id == UserTypes::Admin) {
            // Delete logic for admin
            $comment->delete();
            return back()->with('flash_success', 'Reply deleted successfully.');
        } else {
            return back()->with('flash_error', 'You do not have permission to delete this reply.');
        }
    }

    public function like($commentId)
    {
        $user = Auth::user();
        $comment = Comment::findOrFail($commentId);
        $subscription = Subscription::where('user_id', $user->id)->first();
        $like = Like::where(['user_id' => $user->id, 'comment_id' => $comment->id])->first();
        // if ($user->role_id == UserTypes::User && !$subscription && $user->feature_count < 0) {
        //     return redirect()->back()->with('flash_error', 'To unlock more like and unlike features, please purchase a subscription.');
        // }
        if (!$like) {
            $user->likes()->create(['comment_id' => $comment->id]);
        } else {
            $like->delete();
        }
        return redirect()->back();
    }

    public function getLikeCount($commentId)
    {
        $likeCount = Like::where('comment_id', $commentId)->count();
        return response()->json(['likeCount' => $likeCount]);
    }

    public function likeReply($replyId)
    {
        return $this->like($replyId);
    }

    public function getReplyLikeCount($replyId)
    {
        return $this->getLikeCount($replyId);
    }

    // Posts
    public function togglePostLike($postId)
    {
        $user = Auth::user();
        $textPost = Post::findOrFail($postId);
        $subscription = Subscription::where('user_id', $user->id)->first();
        $like = LikePost::where(['user_id' => $user->id, 'likeable_id' => $textPost->id, 'likeable_type' => Post::class])->first();
        // if ($user->role_id == UserTypes::User && !$subscription && $user->feature_count < 0) {
        //     return redirect()->back()->with('flash_error', 'To unlock more like and unlike features, please purchase a subscription.');
        // }
        if (!$like) {
            $textPost->likes()->create(['user_id' => $user->id]);
            // if ($user->role_id == UserTypes::User) {
            //     $user->feature_count -= 1;
            //     $user->save();
            // }
        } else {
            $like->delete();
        }
        return redirect()->back();
    }

    public function getPostLikeCount($postId)
    {
        $postLikeCount = LikePost::where('likeable_type', Post::class)
            ->where('likeable_id', $postId)
            ->count();
        return response()->json(['postLikeCount' => $postLikeCount]);
    }

    // Polls
    public function togglePollLike($postId)
    {
        $user = Auth::user();
        $textPost = Poll::findOrFail($postId);
        $subscription = Subscription::where('user_id', $user->id)->first();
        $like = LikePost::where(['user_id' => $user->id, 'likeable_id' => $textPost->id, 'likeable_type' => Poll::class])->first();
        // if ($user->role_id == UserTypes::User && !$subscription && $user->feature_count < 0) {
        //     return redirect()->back()->with('flash_error', 'To unlock more like and unlike features, please purchase a subscription.');
        // }
        if (!$like) {
            $textPost->likes()->create(['user_id' => $user->id]);
            // if ($user->role_id == UserTypes::User) {
            //     $user->feature_count -= 1;
            //     $user->save();
            // }
        } else {
            $like->delete();
        }
        return redirect()->back();
    }

    public function getPollLikeCount($pollId)
    {
        $pollLikeCount = LikePost::where('likeable_type', Poll::class)
            ->where('likeable_id', $pollId)
            ->count();
        return response()->json(['pollLikeCount' => $pollLikeCount]);
    }

    // Files
    public function toggleFileLike($postId)
    {
        $user = Auth::user();
        $textPost = Post::findOrFail($postId);
        $subscription = Subscription::where('user_id', $user->id)->first();
        $like = LikePost::where(['user_id' => $user->id, 'likeable_id' => $textPost->id, 'likeable_type' => Post::class])->first();
        // if ($user->role_id == UserTypes::User && !$subscription && $user->feature_count < 0) {
        //     return redirect()->back()->with('flash_error', 'To unlock more like and unlike features, please purchase a subscription.');
        // }
        if (!$like) {
            $textPost->likes()->create(['user_id' => $user->id]);
            // if ($user->role_id == UserTypes::User) {
            //     $user->feature_count -= 1;
            //     $user->save();
            // }
        } else {
            $like->delete();
        }
        return redirect()->back();
    }

    public function getFileLikeCount($fileId)
    {
        $fileLikeCount = LikePost::where('likeable_type', File::class)
            ->where('likeable_id', $fileId)
            ->count();
        return response()->json(['fileLikeCount' => $fileLikeCount]);
    }

    // Gifs
    public function toggleGifLike($gifId)
    {
        $user = Auth::user();
        $textPost = Gif::findOrFail($gifId);
        $subscription = Subscription::where('user_id', $user->id)->first();
        $like = LikePost::where(['user_id' => $user->id, 'likeable_id' => $textPost->id, 'likeable_type' => Gif::class])->first();
        // if ($user->role_id == UserTypes::User && !$subscription && $user->feature_count < 0) {
        //     return redirect()->back()->with('flash_error', 'To unlock more like and unlike features, please purchase a subscription.');
        // }
        if (!$like) {
            $textPost->likes()->create(['user_id' => $user->id]);
            // if ($user->role_id == UserTypes::User) {
            //     $user->feature_count -= 1;
            //     $user->save();
            // }
        } else {
            $like->delete();
        }
        return redirect()->back();
    }

    public function getGifLikeCount($gifId)
    {
        $gifLikeCount = LikePost::where('likeable_type', Gif::class)
            ->where('likeable_id', $gifId)
            ->count();
        return response()->json(['gifLikeCount' => $gifLikeCount]);
    }

    public function toggleMediaLike($batchNumber)
    {
        $user = Auth::user();
        $mediaPost = ModelsMedia::where('batch_number', $batchNumber)->firstOrFail();
        $subscription = Subscription::where('user_id', $user->id)->first();
        $collectionIdentifier = $mediaPost->batch_number;

        $like = LikePost::where([
            'user_id' => $user->id,
            'likeable_id' => $collectionIdentifier,
            'likeable_type' => ModelsMedia::class
        ])->first();

        // if ($user->role_id == UserTypes::User && !$subscription && $user->feature_count < 0) {
        //     return redirect()->back()->with('flash_error', 'To unlock more like and unlike features, please purchase a subscription.');
        // }

        if (!$like) {
            // Create a like for the entire collection
            LikePost::create([
                'user_id' => $user->id,
                'likeable_id' => $collectionIdentifier,
                'likeable_type' => ModelsMedia::class
            ]);
            // if ($user->role_id == UserTypes::User) {
            //     $user->feature_count -= 1;
            //     $user->save();
            // }
        } else {
            $like->delete();
        }
        return redirect()->back();
    }

    public function getMediaLikeCount($mediaId)
    {
        $mediaId = (int)$mediaId;
        $mediaLikeCount = LikePost::where('likeable_type', ModelsMedia::class)
            ->where('likeable_id', $mediaId)
            ->count();
        return response()->json(['mediaLikeCount' => $mediaLikeCount]);
    }

    // Features for a group
    public function group()
    {
        $user = Auth::user();
        if ($user->role_id == UserTypes::Admin) {
            $groups = Group::get();
        } else {
            $groups = Group::where('privacy_type', '<>', 'Secret')->get();
        }
        $userWithGroups = User::with('groups.user')->findOrFail($user->id);

        $user_group = UserGroup::where('user_id', $user->id)
            ->whereIn('group_id', $groups->pluck('id')->toArray())
            ->where('accepted', 1)
            ->where('blocked', 0)
            ->get();
        return view('admin.group.index', compact('groups', 'userWithGroups', 'user_group'));
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'group_name' => 'required|max:64',
            'group_description' => 'required|max:1500',
            'privacy_type' => 'in:Open,Private,Secret',
            'group_photo' => 'file|nullable|mimes:jpeg,jpg,png,gif,bmp,webp,tiff,svg,svgz,tif',
            'group_cover_image' => 'file|nullable|mimes:jpeg,jpg,png,gif,bmp,webp,tiff,svg,svgz,tif',
        ]);

        $directory = 'group_details';
        if (!File::exists($directory)) {
            FacadesFile::makeDirectory($directory, 0777, true, true);
        }

        // Handle group photo upload
        $groupPhotoPath = null;
        if ($request->hasFile('group_photo') && $request->file('group_photo')->isValid()) {
            $file = $request->file('group_photo');
            $groupPhotoPath = Media::convertFullUrl(Media::fileUpload($file));
        }

        // Handle group cover image upload
        $groupCoverPath = null;
        if ($request->hasFile('group_cover_image') && $request->file('group_cover_image')->isValid()) {
            $file = $request->file('group_cover_image');
            $groupCoverPath = Media::convertFullUrl(Media::fileUpload($file));
        }

        try {
            $user = auth()->user();
            Group::create([
                'group_name' => $request->input('group_name'),
                'group_description' => $request->input('group_description'),
                'privacy_type' => $request->input('privacy_type'),
                'user_id' => $user->id,
                'group_photo' => $groupPhotoPath ?? null,
                'group_cover_image' => $groupCoverPath ?? null,
            ]);

            return redirect()->route('dashboard.group')->with('success', 'Group created successfully');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.group')->with('error', 'An error occurred while creating the group.');
        }
    }

    public function viewGroup($id)
    {
        $group = Group::findOrFail($id);
        $categories = Category::get();
        $group_posts = GroupPost::where('group_id', $id)
            ->whereNotIn('type', ['Image', 'Video'])
            ->get();
        $groupComments = GroupPostComments::with('groupPost')
            ->whereHas('groupPost', function ($query) use ($id) {
                $query->where('group_id', $id);
            })
            ->get();
        $commentsByPost = [];
        foreach ($groupComments as $comment) {
            $postId = $comment->post_id;
            $commentsByPost[$postId][] = $comment;
        }
        $grouped_media = GroupPost::where('group_id', $id)
            ->whereIn('type', ['Image', 'Video'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('media_batch_number');

        return view('admin.group.view', compact('group', 'categories', 'group_posts', 'grouped_media', 'commentsByPost'));
    }

    public function postInGroup(Request $request, $groupId)
    {
        try {
            $rules = [
                'text_post' => 'required_if:type,text',
                'media_url.*' => 'file|mimes:jpeg,jpg,png,gif,bmp,webp,tiff,svg,svgz,tif,mp4,avi,wmv,mov,mkv,flv,3gp,mpeg,mpg|max:2048',
                'poll_options' => 'required_if:type,poll|array',
                'file_path' => 'required_if:type,file',
                'gif_url' => 'required_if:type,gif',
            ];
            $request->validate($rules);

            if ($request->input('text_post')) {
                GroupPost::create([
                    'text_post' => $request->input('text_post'),
                    'type' => $request->input('type'),
                    'user_id' => auth()->user()->id,
                    'group_id' => $groupId,
                ]);
            } elseif ($request->hasFile('media_url')) {
                $latestBatchNumber = GroupPost::where('group_id', $groupId)->max('media_batch_number');
                $batchNumber = $latestBatchNumber ? $latestBatchNumber + 1 : 1;
                foreach ($request->file('media_url') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $type = in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'svgz', 'tif']) ? 'Image' : 'Video';
                    $media = Media::convertFullUrl(Media::uploadMedia($file));
                    GroupPost::create([
                        'media_url' => $media,
                        'type' => $type,
                        'category_id' => $request->input('category_id'),
                        'user_id' => auth()->user()->id,
                        'group_id' => $groupId,
                        'media_batch_number' => $batchNumber,
                    ]);
                }
            } elseif ($request->hasFile('file_path')) {
                $directory = 'uploads';
                if (!File::exists($directory)) {
                    FacadesFile::makeDirectory($directory, 0777, true, true);
                }

                if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
                    $file = $request->file('file_path');
                    $file_name = $file->getClientOriginalName();
                    $fileConvert = Media::convertFullUrl(Media::fileUpload($file));
                    GroupPost::create([
                        'file_path' => $fileConvert,
                        'file_details' => $request->input('file_details'),
                        'file_name' => $file_name,
                        'type' => $request->input('type'),
                        'user_id' => auth()->user()->id,
                        'group_id' => $groupId
                    ]);
                }
            } elseif ($request->input('gif_url')) {
                GroupPost::create([
                    'gif_url' => $request->input('gif_url'),
                    'type' => $request->input('type'),
                    'user_id' => auth()->user()->id,
                    'group_id' => $groupId
                ]);
            }
            return redirect()->back()->with('flash_success', 'Post created successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->with('flash_error', $e->validator->errors()->first());
        }
    }

    public function groupPostComments(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'comment' => 'required|string|max:255',
                'media_batch_number' => 'nullable|integer',
            ]);
            $user_id = auth()->user()->id;
            $post = GroupPost::findOrFail($id);
            $comment = GroupPostComments::create([
                'user_id' => $user_id,
                'comment' => $request->input('comment'),
                'group_id' => $request->input('group_id'),
                'post_id' => $post->id,
            ]);
            if ($post->type === 'media') {
                $comment->media_batch_number = $request->input('media_batch_number');
            }
            $comment->save();
            return redirect()->back()->with('flash_success', 'Comment posted successfully');
        }
    }

    public function editGroupComment(Request $request, $commentId)
    {
        $comment = GroupPostComments::findOrFail($commentId);
        $user = auth()->user();
        // Check if the user has permission to edit the comment

        if (
            ($user->role_id == UserTypes::User && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Admin)
        ) {
            if ($comment->groupPost->group_id == $request->input('group_id')) {
                $comment->update([
                    'comment' => $request->input('comment'),
                ]);
                return redirect()->back()->with('flash_success', 'Comment updated successfully.');
            } else {
                return back()->with('flash_error', 'You do not have permission to edit this comment.');
            }
        } else {
            return back()->with('flash_error', 'You do not have permission to edit this comment.');
        }
    }

    public function deleteGroupComment($commentId)
    {
        $comment = GroupPostComments::findOrFail($commentId);
        $user = auth()->user();
        if (
            ($user->role_id == UserTypes::User && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $comment->user_id === $user->id)
        ) {
            if ($comment->groupPost->group_id == $comment->group_id) {
                // for end users or moderators
                $comment->delete();
                return back()->with('flash_success', 'Comment deleted successfully.');
            } else {
                return back()->with('flash_error', 'You do not have permission to delete this comment.');
            }
        } elseif ($user->role_id == UserTypes::Admin) {
            if ($comment->groupPost->group_id == $comment->group_id) {
                // for admin
                $comment->delete();
                return back()->with('flash_success', 'Comment deleted successfully.');
            } else {
                return back()->with('flash_error', 'You do not have permission to delete this comment.');
            }
        } else {
            return back()->with('flash_error', 'You do not have permission to delete this comment.');
        }
    }

    public function groupCommentReplies(Request $request, $commentId)
    {
        $user = Auth::user();
        $request->validate([
            'comment' => 'required|string',
        ]);

        $parentComment = GroupPostComments::with('groupPost')->find($commentId);

        if (!$parentComment) {
            return back()->with('flash_error', 'Comment not found.');
        }

        $reply = new GroupPostComments([
            'comment' => $request->input('comment'),
            'parent_id' => $commentId,
            'user_id' => $user->id,
            'group_id' => $parentComment->groupPost->group_id,
        ]);
        $parentComment->replies()->save($reply);
        // if ($user->role_id == UserTypes::User) {
        //     $user->feature_count -= 1;
        //     $user->save();
        // }

        return redirect()->back()->with('flash_success', 'Reply added successfully.');
    }

    public function editGroupCommentReply(Request $request, $replyId)
    {
        $reply = GroupPostComments::findOrFail($replyId);
        $user = auth()->user();

        if (
            ($user->role_id == UserTypes::User && $reply->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $reply->user_id === $user->id) ||
            ($user->role_id == UserTypes::Admin)
        ) {
            $reply->update([
                'comment' => $request->input('comment'),
            ]);

            return back()->with('flash_success', 'Reply updated successfully.');
        } else {
            return back()->with('flash_error', 'You do not have permission to update this reply.');
        }
    }



    public function deleteGroupReply($replyId)
    {
        $comment = GroupPostComments::findOrFail($replyId);
        $user = auth()->user();
        if (
            ($user->role_id == UserTypes::User && $comment->user_id === $user->id) ||
            ($user->role_id == UserTypes::Moderator && $comment->user_id === $user->id)
        ) {
            // Delete logic for end users or moderators
            $comment->delete();
            return back()->with('flash_success', 'Reply deleted successfully.');
        } elseif ($user->role_id == UserTypes::Admin) {
            // Delete logic for admin
            $comment->delete();
            return back()->with('flash_success', 'Reply deleted successfully.');
        } else {
            return back()->with('flash_error', 'You do not have permission to delete this reply.');
        }
    }

    public function likeGroupPost($postId)
    {
        $user = Auth::user();
        $groupPost = GroupPost::find($postId);
        if (!$groupPost) {
            return response()->json(['error' => 'Group post not found.'], 404);
        }
        $existingLike = GroupPostLike::where([
            'user_id' => $user->id,
            'post_id' => $postId,
        ])->first();
        if ($existingLike) {
            $existingLike->delete();
            $groupPost->decrement('likes');
            $liked = false;
        } else {
            GroupPostLike::create([
                'user_id' => $user->id,
                'post_id' => $postId,
                'group_id' => $groupPost->group_id,
                'liked' => true,
            ]);
            $groupPost->increment('likes');
            $liked = true;
        }
        return response()->json(['liked' => $liked]);
    }

    public function toggleLikeGroupMedia($media_batch_number)
    {
        try {
            $user = Auth::user();

            // Check if the user already liked the media batch
            $existingLike = GroupPostLike::where([
                'user_id' => $user->id,
                'media_batch_number' => $media_batch_number,
            ])->first();

            if ($existingLike) {
                // User already liked, unlike the media batch
                $existingLike->delete();

                // Decrement the likes count for all media posts in the batch
                GroupPost::where('media_batch_number', $media_batch_number)
                    ->whereIn('type', ['Image', 'Video'])
                    ->decrement('likes');

                return response()->json([
                    'liked' => false,
                ]);
            } else {
                // User hasn't liked, like the media batch
                GroupPostLike::create([
                    'user_id' => $user->id,
                    'media_batch_number' => $media_batch_number,
                    'liked' => true,
                ]);

                // Increment the likes count for all media posts in the batch
                GroupPost::where('media_batch_number', $media_batch_number)
                    ->whereIn('type', ['Image', 'Video'])
                    ->increment('likes');

                return response()->json([
                    'liked' => true,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    public function likeGroupPostCount($postId)
    {
        $groupPost = GroupPost::find($postId);
        $likesCount = $groupPost->likes;
        return response()->json(['likesCount' => $likesCount]);
    }

    public function likeGroupMediaCount($postId)
    {
        $groupPost = GroupPost::where('type', 'Image')->orWhere('type', 'Video')->find($postId);
        $likesCount = $groupPost->likes;
        return response()->json(['likesCount' => $likesCount]);
    }

    public function likeGroupComment($commentId)
    {
        try {
            $user = auth()->user();
            $comment = GroupPostComments::findOrFail($commentId);
            // Check feature count
            // if ($user->feature_count < 0 && $user->role_id == UserTypes::User) {
            //     return redirect()->back()->with('flash_error', 'Your free trial is over, kindly purchase a subscription to continue using the features.');
            // }
            $like = GroupPostCommentLike::where([
                'user_id' => $user->id,
                'comment_id' => $comment->id,
            ])->first();
            if ($like) {
                $like->delete();
            } else {
                GroupPostCommentLike::create([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                    'group_id' => $comment->group_id,
                    'post_id' => $comment->post_id,
                ]);
            }
            return redirect()->back()->with('success', 'Comment liked/unliked successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('flash_error', 'Comment not found.');
        }
    }

    public function groupCommentLikeCount($commentId)
    {
        $likeCount = GroupPostCommentLike::where('comment_id', $commentId)->count();
        return response()->json(['likeCount' => $likeCount]);
    }

    // group applications
    public function userApplyToGroup(Request $request)
    {
        $user = Auth::user();
        $groupId = $request->input('id');
        $existingApplication = UserGroup::where('user_id', $user->id)
            ->where('group_id', $groupId)
            ->first();
        if ($existingApplication) {
            return redirect()->back()->with('flash_error', 'You have already applied to this group.');
        }
        UserGroup::create([
            'user_id' => $user->id,
            'group_id' => $groupId,
        ]);
        return redirect()->back()->with('flash_success', 'Application submitted successfully!');
    }

    // show applicants
    public function showApplicants($id)
    {
        $group = Group::findOrFail($id);
        $applicants = $group->userGroups()->where('accepted', 0)->where('blocked', 0)->get();
        return view('admin.group.applicants', [
            'group' => $group,
            'applicants' => $applicants
        ]);
    }

    public function accpetUsers($id, Request $request)
    {
        $userId = $request->user_id;
        // Ensure that both the group and user exist
        $group = UserGroup::where('group_id', $id)->where('user_id', $userId)->firstOrFail();
        $group->update(['accepted' => 1]);
        return redirect()->back()->with('flash_success', 'User has been added to the group');
    }

    // remove members from a group
    public function removeMembers($id, Request $request)
    {
        $userId = $request->user_id;
        // Ensure that both the group and user exist
        $group = UserGroup::where('group_id', $id)->where('user_id', $userId)->firstOrFail();
        $group->update(['accepted' => 0]);
        return redirect()->back()->with('flash_success', 'User has been removed from the group');
    }

    // accept applicants
    public function groupMembers($id)
    {
        $group = Group::findOrFail($id);
        $acceptedUsers = $group->userGroups()->where('accepted', 1)->get();
        $admin = User::where('role_id', UserTypes::Admin)->first();
        $adminCount = $admin ? 1 : 0;
        return view('admin.group.members', [
            'group' => $group,
            'acceptedUsers' => $acceptedUsers,
            'admin' => $admin,
            'adminCount' => $adminCount,
        ]);
    }

    // reject a user
    public function rejectApplicant(Request $request, $id)
    {
        $userId = $request->user_id;
        // Ensure that both the group and user exist
        $group = UserGroup::where('group_id', $id)->where('user_id', $userId)->firstOrFail();
        $group->update(['blocked' => 1]);
        return redirect()->back()->with('flash_success', 'User application has been rejected');
    }

    // rejected applicants
    public function rejectUsers($id)
    {
        $group = Group::findOrFail($id);
        $rejectedUsers = $group->userGroups()->where('accepted', 0)->where('blocked', 1)->get();
        return view('admin.group.rejected_members', [
            'group' => $group,
            'rejectedUsers' => $rejectedUsers
        ]);
    }

    // Unblock a user
    public function unblockUser(Request $request, $id)
    {
        $userId = $request->user_id;
        $group = UserGroup::where('group_id', $id)
            ->where('user_id', $userId)
            ->where('accepted', 0)
            ->where('blocked', 1)
            ->first();
        $group->update(['blocked' => 0]);
        return redirect()->back()->with('flash_success', 'User has been unblocked from the group');
    }

    // Invitation page
    public function inviteUsers()
    {
        $secretGroup = Group::where('privacy_type', 'Secret')->first();
        // Get active users who have not been invited to the secret group
        $activeUsers = User::where('role_id', UserTypes::User)
            ->where('status', 1)
            ->whereNotIn('id', function ($query) use ($secretGroup) {
                $query->select('user_id')
                    ->from('user_groups')
                    ->where('group_id', $secretGroup->id)
                    ->where('invitation', 1);
            })
            ->get();
        return view('admin.group.active_members', compact('activeUsers', 'secretGroup'));
    }

    // Send invites
    public function sendInvites(Request $request)
    {
        $invitation = UserGroup::create([
            'group_id' => $request->group_id,
            'user_id' => $request->user_id,
            'invitation' => 1,
        ]);
        $user = $invitation->user->first_name . ' ' . $invitation->user->last_name;
        return redirect()->back()->with('flash_success', $user . ' has been invited to the group');
    }

    // Notification page
    public function notification()
    {
        return view('admin.notification.index');
    }
}
