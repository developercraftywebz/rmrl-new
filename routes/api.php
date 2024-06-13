<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\PostCommentController;
use App\Http\Controllers\API\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('/verify-otp', [UserController::class, 'verification']);
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
Route::post('reset-password', [UserController::class, 'resetPassword']);
Route::post('social-authentication', [UserController::class, 'socialAuthentication']);

// Common APIs
Route::post('get-countries/{id?}', [CommonController::class, 'getCountries']);
Route::post('get-states/{id}', [CommonController::class, 'getStates']);
Route::post('get-cities/{id}', [CommonController::class, 'getcities']);
Route::post('terms-and-condition', [CommonController::class, 'termsAndCondition']);
Route::post('privacy-policy', [CommonController::class, 'privacyPolicy']);

Route::middleware('auth:api')->group(function () {
    Route::group(['middleware' => 'check.user'], function () {
        Route::post('logout', [UserController::class, 'logout']);

        Route::post('edit-profile', [UserController::class, 'editProfile']);
        Route::post('edit-profile/upload-picture', [UserController::class, 'uploadPicture']);
        Route::post('get-profile-details', [UserController::class, 'getProfileDetails']);

        Route::post('create-chat-room', [UserController::class, 'createChatRoom']);
        Route::post('get-all-chats-rooms', [UserController::class, 'getAllChatsRooms']);

        // Media routes (Stream posts)
        Route::get('get-media', [UserController::class, 'getMedia']);
        Route::get('get-media-posts', [UserController::class, 'getCombinedData']);


        Route::get('/get-media-comment', [UserController::class, 'getMediaComments']);
        Route::get('/get-comment-reply', [UserController::class, 'getCommentReplies']);
        Route::get('/get-like-dislike-reply', [UserController::class, 'getReplyLikes']);
        Route::get('/get-all-liked-comments', [UserController::class, 'getLikedComments']);
        Route::get('/get-all-category', [UserController::class, 'getAllCategory']);

        Route::post('/like-dislike', [UserController::class, 'toggleLike']);
        Route::post('/media-comment', [UserController::class, 'mediaComment']);
        Route::post('/media-comment-reply', [UserController::class, 'commentReply']);
        Route::post('/like-dislike-comment', [UserController::class, 'toggleCommentLike']);
        Route::post('/like-dislike-reply', [UserController::class, 'toggleReplyLike']);
        Route::post('/comment/like', [UserController::class, 'likeComment']);


        // Group routes
        Route::get('/admin/group', [UserController::class, 'getGroup']);

        // Plans routes
        Route::get('/plans', [App\Http\Controllers\Admin\PlansController::class, 'index']);
        Route::get('/plan/view/{id}', [App\Http\Controllers\Admin\PlansController::class, 'planDetails']);
        Route::get('/get-plans', [SubscriptionController::class, 'getPlans']);
        Route::post('/purchase-plan', [SubscriptionController::class, 'purchasePlanApi']);
        Route::post('/revoke-plan', [SubscriptionController::class, 'cancelPlan']);
        Route::post('/add-post-comment', 'App\Http\Controllers\api\PostCommentController@addPostComment');

        // view post comments route
        Route::get('/view-post-comments', 'App\Http\Controllers\api\PostCommentController@viewPostComments');

        // update post route
        Route::post('/update-post-comment', 'App\Http\Controllers\api\PostCommentController@updatePostComment');




        Route::post('/like-dislike-post-comment', [PostCommentController::class, 'addDeletePostCommentLike']);
        // delete post comment route
        Route::get('/get-group-media-posts', [UserController::class, 'combinedGroupPosts']);

        Route::delete('/delete-post-comment/{id}', 'App\Http\Controllers\api\PostCommentController@deletePostComment');

        Route::post('post/add-comment-reply', 'App\Http\Controllers\api\PostCommentController@addCommentReply');
        Route::post('post/comment/add-delete-like', 'App\Http\Controllers\api\PostCommentController@addDeleteCommentLike');

        Route::post('post/comment/add-delete-like', 'App\Http\Controllers\api\PostCommentController@addDeleteCommentLike');

        Route::get('/comments/{postId}', 'App\Http\Controllers\api\PostCommentController@getCommentsByPostId');
        // all post types
        Route::post('/group-posts/comments/reply', [UserController::class, 'replyToCommentOnGroupPost']);
        Route::post('/group-media/comments/reply', [UserController::class, 'replyToCommentOnGroupMedia']);
        Route::get('/group-posts/comments-on-media', [UserController::class, 'getAllCommentsOnGroupMedia']);
        Route::get('/group-posts/comments', [UserController::class, 'getAllCommentsAndRepliesForPost']);


        Route::get('/posts', [UserController::class, 'allPosts']);

        // show group posts (not media)
        Route::get('/group-post/{id}', [UserController::class, 'groupPost']);
        Route::get('get-all-admin', [UserController::class, 'admin']);
        Route::get('/get-all-comments', [UserController::class, 'getAllGroupsComment']);



        // comment on a group post (not media)
        Route::post('/group-posts/comment', [UserController::class, 'commentOnGroupPost']);

        // show group posts (only media)
        Route::get('/groups-post-media', [UserController::class, 'groupPostMedia']);


        // comment on media posts in a specific group
        Route::post('/group-posts/comment-on-media', [UserController::class, 'commentOnMediaPost']);
        Route::get('/group-posts/{id}/get-comments-on-media', [UserController::class, 'getCommentsOnMediaPost']);

        // Like group post media post comment
        Route::post('/group-posts/comments/like', [UserController::class, 'likeCommentOnMediaPost']);

        // Route::get('/group-media-comment/{media_batch_number}', [UserController::class, 'groupPost']);

        // submit poll
        Route::post('/poll-submit', [UserController::class, 'submitPoll']);

        // Comments
        Route::get('/comment/like/{commentId}', [UserController::class, 'like']);
        Route::get('/comment/like-count/{commentId}', [UserController::class, 'getLikeCount']);

        // Post like
        Route::get('/post-like/{postId}', [UserController::class, 'postLike']);
        Route::get('/notification', [UserController::class, 'getAllNotifications']);

        Route::get('/post-like-count/{postId}', [UserController::class, 'postLikeCount']);

        // Poll like
        Route::get('/poll-like/{pollId}', [UserController::class, 'pollLike']);
        Route::get('/poll-like-count/{pollId}', [UserController::class, 'pollLikeCount']);

        // Gif like
        Route::get('/gif-like/{gifId}', [UserController::class, 'gifLike']);
        Route::get('/gif-like-count/{gifId}', [UserController::class, 'gifLikeCount']);

        // Group posts
        Route::get('/like-group-post/{groupPostId}', [UserController::class, 'likeGroupPost']);
        Route::get('/liked-group-post-count/{groupPostId}', [UserController::class, 'likeGroupPostCount']);

        // Group media
        Route::get('/group-post-media', [UserController::class, 'toggleLikeGroupMedia']);
        Route::get('/like-group-media', [UserController::class, 'toggleLikeGroupMedia']);
        Route::get('/liked-group-media-count/{media_batch_number}', [UserController::class, 'likeGroupMediaCount']);

        // Apply to a group
        Route::post('/groups/apply', [UserController::class, 'userApplyToGroup'])->name('groups.apply');
    });
});
