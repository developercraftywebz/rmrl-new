<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\MyFavoriteGame;
use App\Models\ProfileImage;
use App\Models\CommentLike;
use App\Models\MatchFriend;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use Carbon\Carbon;
use Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

use App\Models\Notification;
use App\Helper\Helper;
use App\Models\ContactUs;
use App\Models\PostCommentLike;
use App\Models\TermsAndCondition;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mockery\Matcher\Contains;

class PostCommentController extends Controller
{
    public function addPostComment(Request $request)
    {
        $data = $request->all();
        $user_id = $request->user()->id;

        $validator = Validator::make($data, [
            'post_id' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ];

            return response()->json($response, 422);
        } else {
            $post_id = $data['post_id'];
            $message = $data['message'];
            $parent_id = isset($data['parent_id']) ? $data['parent_id'] : 0;

            $findPost = Post::find($post_id);

            if ($findPost) {
                $comment_post = new PostComment();
                $comment_post->message = $message;
                $comment_post->user_id = $user_id;
                $comment_post->post_id = $post_id;
                $comment_post->parent_id = $parent_id;
                $comment_post->status = 'add';
                $comment_post->save();

                if ($comment_post) {
                    // Fetch the comment data
                    $commentData = $comment_post->refresh(); // Refresh to get the latest data

                    // ... (rest of your code)

                    $response = [
                        'status' => 201,
                        'success' => true,
                        'message' => 'Commented on post Successfully',
                        'data' => $commentData, // Include the comment data in the response
                    ];

                    return response()->json($response, 201);
                } else {
                    $response = [
                        'status' => 400,
                        'success' => false,
                        'message' => 'Something went wrong in post comment',
                        'data' => ''
                    ];

                    return response()->json($response, 400);
                }
            } else {
                $response = [
                    'status' => 404,
                    'success' => false,
                    'message' => 'Post Model not found',
                    'data' => ''
                ];

                return response()->json($response, 404);
            }
        }
    }


    public function getCommentsByPostId($postId)
    {

        $authUserId = Auth::id();  // Assuming you're using Laravel's Auth facade to get the authenticated user's ID

        $comments = PostComment::with(['users', 'children.users'])
            ->where('post_id', $postId)
            ->get();

        $responseArray = [];
        $commentMap = [];

        foreach ($comments as $comment) {
            $commentMap[$comment->id] = $comment;
        }

        foreach ($comments as $comment) {
            // Setting properties for both parent and child comments
            $comment->like_count = $comment->getLikeCountAttribute();
            $comment->dislike_count = $comment->getDislikeCountAttribute();

            $comment->auth_user_like = null;

            // Check if the authenticated user has liked or disliked this comment
            $like = PostCommentLike::where('comment_id', $comment->id)
                ->where('user_id', $authUserId)
                ->first();

            if ($like) {
                $comment->auth_user_like = $like->type === 'like' ? true : false;
            }

            if ($comment->parent_id !== null && isset($commentMap[$comment->parent_id])) {
                $parentComment = $commentMap[$comment->parent_id];
                if (!isset($parentComment->children)) {
                    $parentComment->children = [];
                }

                // ... (rest of your logic for handling child comments)

                // Ensure that child comments also have the properties set
                foreach ($parentComment->children as $childComment) {
                    $childComment->like_count = $childComment->getLikeCountAttribute();
                    $childComment->dislike_count = $childComment->getDislikeCountAttribute();

                    $childComment->auth_user_like = null;

                    // Check if the authenticated user has liked or disliked this child comment
                    $childLike = PostCommentLike::where('comment_id', $childComment->id)
                        ->where('user_id', $authUserId)
                        ->first();

                    if ($childLike) {
                        $childComment->auth_user_like = $childLike->type === 'like' ? true : false;
                    }
                }
            } else {
                $responseArray[] = $comment;
            }
        }


        $rootComments = array_filter($responseArray, function ($comment) {
            return $comment->parent_id === null;
        });

        return response()->json(array_values($rootComments), 200);
    }




    public function getTerms(Request $request, $type)
    {
        $validator = Validator::make(['type' => $type], [
            'type' => 'required|string|in:privacyPolicy,termsAndCondition',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ];
            return response()->json($response, 422);
        }

        try {
            // Fetch terms based on the provided type
            $terms = TermsAndCondition::where('type', $type)->first();

            // Check if terms exist for the given type
            if (!$terms) {
                return response()->json(['message' => 'Terms not found for the provided type'], 404);
            }

            return response()->json(['message' => 'Data fetched successfully', 'data' => $terms], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch data', 'error' => $e->getMessage()], 500);
        }
    }

    //   public function viewPostComments(Request $request){
    //   	$data = $request->all();

    // $validator = Validator::make($data, [
    //     'post_id' => 'required',
    // ]);

    // if($validator->fails()){
    // 	$response = [
    //               'status' => 422,
    //               'success' => false,
    //               'message' => 'fields are incorrect or missing',
    //               'data' => $validator->errors()
    //           ];

    //           return response()->json($response, 401);
    //   	}else{
    //   		$post_id = $data['post_id'];

    //        $post_comments = Post::with('post_comments')->has('post_comments')->where('id',$post_id)->get();

    //        if($post_comments){
    //            $response = [
    //                'status' => 200,
    //                'success' => true,
    //                'message' => "All users post Comment list",
    //                'data' => $post_comments
    //            ];

    //            return response()->json($response, 200);
    //        }else{
    //            $response = [
    //             'status' => 404,
    //             'success' => false,
    //             'message' => "Model not found",
    //             'data' => ''
    //         ];

    //        	return response()->json($response, 404);
    //        }
    //    }
    //   }

    // public function viewPostComments(Request $request){
    // 	$post_id = $request->post_id;

    //     $user_post_comments = Post::with('post_comments','post_comments.users','post_comments.users.user_meta','post_comments.users.profile_images')->withCount('post_likes','post_comments')->where('id', $post_id)->first();

    //     if($user_post_comments){
    //         $response = [
    //             'status' => 200,
    //             'success' => true,
    //             'message' => "View post comments successfully",
    //             'data' => $user_post_comments
    //         ];

    //         return response()->json($response, 200);
    //     }else{
    //         $response = [
    //          'status' => 404,
    //          'success' => false,
    //          'message' => "Users post comments not found",
    //          'data' => ''
    //      ];

    //     	return response()->json($response, 404);
    //     }
    // }


    public function termsAndCondition(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'type' => 'required|string|in:privacyPolicy,termsAndCondition',
            'text' => 'required|string',
        ]);

        // Create a new instance of TermsAndCondition model
        $terms = new TermsAndCondition();

        // Assign values
        $terms->text = $request->input('text');
        $terms->type = $request->input('type'); // Set the type column based on the input

        try {
            $terms->save();
            return response()->json(['message' => 'Data saved successfully', 'data' => $terms], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
    }

    public function contact(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string',

            'image1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5048'],
            'image2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5048'],
            'image3' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5048'],
        ]);

        // Create a new ContactUs instance
        $contact = new ContactUs();
        $contact->name = $request->input('name');
        $contact->user_id = Auth::user()->id; // Assuming you're using Laravel's built-in Auth
        $contact->email = $request->input('email'); // Corrected from first_name
        $contact->description = $request->input('description'); // Corrected from first_name

        // Save images to respective columns
        // foreach (['image1', 'image2', 'image3'] as $imageField) {
        //     if ($request->hasFile($imageField)) {
        //         $image = $request->file($imageField);
        //         $imageName = time() . '_' . $image->getClientOriginalName();
        //         $image->move(public_path('/images/users'), $imageName);
        //         $contact->$imageField = $imageName;
        //     }
        // }

        foreach (['image1', 'image2', 'image3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                // Delete the old image if it exists (as you were doing before)
                $oldImagePath = public_path('images/contacts/' . basename($contact->$imageField));
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                // Generate a unique name for the image
                $uniqueImageName = time() . '_' . Str::random(10) . '.' . $request->file($imageField)->getClientOriginalExtension();

                // Move the uploaded file to the specified directory with the unique name
                $request->file($imageField)->move(public_path('/images/contacts'), $uniqueImageName);

                // Update the model attribute with the complete URL including the unique name
                $contact->$imageField = URL::to('/images/contacts/' . $uniqueImageName);
            }
        }


        try {
            $contact->save(); // Save the $contact model instance
            return response()->json(['message' => 'Data saved successfully', 'data' => $contact], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
    }


    public function addCommentReply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required'

        ]);

        $responseArray = [];

        if ($validator->fails()) {

            $response = [
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ];

            return response()->json($response, 422);
        }

        try {


            $comment = PostComment::create([
                'message' => $request->comment,
                'user_id' => $request->user()->id,
                'post_id' => $request->post_id,
                'parent_id' => $request->parent_id,


            ]);

            if ($request->parent_id && $request->parent_id != 0) {
                //  Here we define the parent for new created category
                $node = PostComment::find($request->parent_id);

                $node->appendNode($comment);
            }



            $response = [
                'status' => 201,
                'success' => true,
                'message' => "Comment reply added",
                'data' => ''
            ];

            return response()->json($response, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }



    public function viewPostCommentsReply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:post_comments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ], 422);
        }

        try {
            $query = PostComment::where('post_id', $request->post_id);

            if ($request->has('parent_id')) {
                $query->where('parent_id', $request->parent_id);
            } else {
                // If no parent_id is provided, fetch only top-level comments (no parent_id set)
                $query->whereNull('parent_id');
            }

            $comments = $query->get();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Comments fetched successfully',
                'data' => $comments
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
    public function viewPostComments(Request $request)
    {
        $userr = $request->user();

        $user_posts = Post::where('id', $request->post_id)
            ->with('likes', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->withCount('likes', 'post_comments')
            ->first();

        if ($request->has('skip')) {
            // Ensure that blockedUsers relationship is loaded and not null
            $blockedUserIds = $userr->blockedUsers ? $userr->blockedUsers->pluck('id') : [];

            $user_post_comments = PostComment::where(function ($q) use ($blockedUserIds) {
                $q->whereNotIn('user_id', $blockedUserIds);
            })->with(['users', 'likes' => function ($q) use ($userr) {
                $q->where('user_id', $userr->id);
            }])
                ->where('post_id', $request->post_id)
                ->withCount('likes') // Include total likes count for each comment
                ->orderBy('id', 'ASC')
                ->skip($request->skip)
                ->take(10)
                ->get();

            // Transform the data to include total_likes and auth_like for each comment
            $user_post_comments = $user_post_comments->map(function ($comment) use ($userr) {
                $comment->total_likes = $comment->likes_count;
                $comment->auth_like = $comment->likes->isNotEmpty();
                unset($comment->likes, $comment->likes_count); // Remove unnecessary data
                return $comment;
            });

            $user_posts['post_comments'] = $user_post_comments;
        } else {
            // Ensure that blockedUsers relationship is loaded and not null
            $blockedUserIds = $userr->blockedUsers ? $userr->blockedUsers->pluck('id') : [];

            $user_post_comments = PostComment::where(function ($q) use ($blockedUserIds) {
                $q->whereNotIn('user_id', $blockedUserIds);
            })->with(['users', 'likes' => function ($q) use ($userr) {
                $q->where('user_id', $userr->id);
            }])
                ->where('post_id', $request->post_id)
                ->withCount('likes') // Include total likes count for each comment
                ->orderBy('id', 'ASC')
                ->get();

            // Transform the data to include total_likes and auth_like for each comment
            $user_post_comments = $user_post_comments->map(function ($comment) use ($userr) {
                $comment->total_likes = $comment->likes_count;
                $comment->auth_like = $comment->likes->isNotEmpty();
                unset($comment->likes, $comment->likes_count); // Remove unnecessary data
                return $comment;
            });

            $user_posts['post_comments'] = $user_post_comments;
        }

        if ($user_posts) {
            $response = [
                'status' => 200,
                'success' => true,
                'message' => "View post comments successfully",
                'data' => $user_posts
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "Users post comments not found",
                'data' => ''
            ];

            return response()->json($response, 404);
        }
    }




    // post comment likes 

    public function addDeleteCommentLike(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|numeric|exists:post_comments,id',
            'type' => 'required'
        ]);



        if ($validator->fails()) {

            $response = [
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ];

            return response()->json($response, 422);
        }

        try {


            $hasLikes = CommentLike::where([['user_id', Auth::user()->id], ['comment_id', $request->comment_id]])->first();

            if (!is_null($hasLikes)) {

                // $request->user()->commentlikes()->detach($request->comment_id);
                $hasLikes->type = $request->type;
                $hasLikes->update();


                $response = [
                    'status' => 201,
                    'success' => true,
                    'message' => "Comment " . $request->type,
                    'data' => $hasLikes
                ];
            } else {



                // $request->user()->commentlikes()->attach($request->comment_id);

                // $comment = Post::find($request->comment_id);
                $commentLike = new CommentLike();
                $commentLike->user_id = $request->user()->id;
                $commentLike->type = $request->type;
                $commentLike->comment_id = $request->comment_id;
                $commentLike->save();


                $response = [
                    'status' => 201,
                    'success' => true,
                    'message' => "Comment " . $request->type,
                    'data' => $commentLike
                ];
            }

            return response()->json($response, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }



    public function addDeletePostCommentLike(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|numeric|exists:post_comments,id',
            'type' => 'required|in:like,dislike',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors(),
            ];

            return response()->json($response, 422);
        }

        try {
            $user = $request->user();
            $commentId = $request->comment_id;

            // Check if the user has already liked the comment
            $existingLike = PostCommentLike::where('user_id', $user->id)
                ->where('comment_id', $commentId)
                ->first();

            if (!is_null($existingLike)) {
                // User has already liked the comment, toggle the like/dislike
                $existingLike->type = $existingLike->type === 'like' ? 'dislike' : 'like';
                $existingLike->update();

                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => "Comment " . $existingLike->type,
                    'data' => $existingLike,
                ];
            } else {
                // User has not liked the comment, create a new like
                $newLike = new PostCommentLike();
                $newLike->user_id = $user->id;
                $newLike->type = $request->type;
                $newLike->comment_id = $commentId;
                $newLike->save();

                $response = [
                    'status' => 201,
                    'success' => true,
                    'message' => "Comment " . $newLike->type,
                    'data' => $newLike,
                ];
            }

            return response()->json($response, $response['status']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }


    public function updatePostComment(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'comment_id' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ];

            return response()->json($response, 422);
        } else {
            $post_comment_id = $data['comment_id'];
            $message = $data['message'];

            $findPostComment = PostComment::where('id', $post_comment_id)->first();

            if (!is_null($findPostComment)) {

                if ($findPostComment->user_id != $request->user()->id) {

                    $response = [
                        'status' => 422,
                        'success' => false,
                        'message' => "You do not have access to complete this action.",
                        'data' => ''
                    ];

                    return response()->json($response, 422);
                }

                $Update_post = PostComment::where('id', $post_comment_id)->update([
                    'message' => $message
                ]);

                if ($Update_post) {
                    $response = [
                        'status' => 201,
                        'success' => true,
                        'message' => "Post comment is updated Successfully",
                        'data' => ''
                    ];

                    return response()->json($response, 201);
                } else {
                    $response = [
                        'status' => 404,
                        'success' => false,
                        'message' => "Post comment not found",
                        'data' => ''
                    ];

                    return response()->json($response, 404);
                }
            } else {
                $response = [
                    'status' => 404,
                    'success' => false,
                    'message' => "Post comment not found",
                    'data' => ''
                ];

                return response()->json($response, 404);
            }
        }
    }

    public function deletePostComment(Request $request, $id)
    {

        $user_id = $request->user()->id;
        $findPostComment = PostComment::where('id', $id)->first();

        if (!is_null($findPostComment)) {
            $findPost = Post::where('id', $findPostComment->post_id)->first();

            if ($findPostComment->user_id != $request->user()->id) {



                if ($findPost->user_id != $request->user()->id) {
                    $response = [
                        'status' => 422,
                        'success' => false,
                        'message' => "You do not have access to complete this action.",
                        'data' => ''
                    ];

                    return response()->json($response, 422);
                } else {


                    $delete_post_comment = PostComment::where('id', $id)->delete();

                    if ($delete_post_comment) {
                        $response = [
                            'status' => 201,
                            'success' => true,
                            'message' => "Deleted post comment Successfully",
                            'data' => ''
                        ];

                        return response()->json($response, 201);
                    } else {
                        $response = [
                            'status' => 400,
                            'success' => false,
                            'message' => "something wrong accur in deleting post comment",
                            'data' => ''
                        ];

                        return response()->json($response, 400);
                    }
                }
            }

            $delete_post_comment = PostComment::where('id', $id)->delete();

            if ($delete_post_comment) {
                $response = [
                    'status' => 201,
                    'success' => true,
                    'message' => "deleted post comment Successfully",
                    'data' => ''
                ];

                return response()->json($response, 201);
            } else {
                $response = [
                    'status' => 400,
                    'success' => false,
                    'message' => "something wrong accur in deleting post comment",
                    'data' => ''
                ];

                return response()->json($response, 400);
            }
        } else {
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "Comment not found",
                'data' => ''
            ];

            return response()->json($response, 404);
        }
    }
}
