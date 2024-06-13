<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Functions for admins only
Route::middleware(['admin.user'])->group(function () {
    Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');

    // {{HTML::link}}
    Route::post('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::get('/admin/index', [App\Http\Controllers\Admin\UsersController::class, 'adminIndex'])->name('admin.index');
    Route::get('/cms', [App\Http\Controllers\Admin\UsersController::class, 'cms']);
    Route::post('/cms', [App\Http\Controllers\Admin\UsersController::class, 'cms'])->name('cms');
    Route::get('/chats/{roomId?}', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat');
    Route::post('/chats/{roomId?}', [App\Http\Controllers\Admin\ChatController::class, 'index']);
    Route::post('/upload-attachment', [App\Http\Controllers\Admin\ChatController::class, 'uploadAttachment'])->name('upload.attachment');

    // Route for users
    Route::get('/users/index', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UsersController::class, 'create'])->name('users.create');
    Route::post('/users/create', [App\Http\Controllers\Admin\UsersController::class, 'store']);
    Route::get('/users/view/{id}', [App\Http\Controllers\Admin\UsersController::class, 'view'])->name('users.view');
    Route::post('/users/view/{id}', [App\Http\Controllers\Admin\UsersController::class, 'view']);
    Route::post('users/delete/{id}', [App\Http\Controllers\Admin\UsersController::class, 'delete'])->name('users.delete');

    Route::get('/states/get-cities', [App\Http\Controllers\Admin\CommonController::class, 'getCities'])->name('states.get-cities');
    Route::get('/states/get-states', [App\Http\Controllers\Admin\CommonController::class, 'getStates'])->name('states.get-states');

    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index']);

    // Subscriptions
    Route::get('/subscriptions', [App\Http\Controllers\Admin\SubscriptionsController::class, 'index'])->name('subscriptions.index');
    // public function electiveGroup(){
    //     $E1 = FinalyearSubject::get()
    //         ->where('subject_group','=','E1')
    //         ->orWhere('student_number','=',max('student_number'));
    
    //     return view ('admin.elective')->with(compact('E1'));
    // }

    // Plans
    Route::get('/plans/create', [App\Http\Controllers\Admin\PlansController::class, 'create'])->name('plans.create');
    Route::post('/plans/create', [App\Http\Controllers\Admin\PlansController::class, 'create']);
    Route::get('/plans/edit/{id}', [App\Http\Controllers\Admin\PlansController::class, 'update'])->name('plans.edit');
    Route::post('/plans/edit/{id}', [App\Http\Controllers\Admin\PlansController::class, 'update']);
    Route::post('/plans/delete/{id}', [App\Http\Controllers\Admin\PlansController::class, 'delete']);

    // Profile and cover pictures
    Route::post('/upload-image', [UsersController::class, 'uploadImage'])->name('upload.image');
    Route::post('/upload-image/delete', [UsersController::class, 'deleteImage'])->name('upload.image.delete');

    // about
    Route::get('/about',  [UsersController::class, 'about'])->name('user.about');
    Route::post('/about', [UsersController::class, 'about'])->name('user.updateAbout');
    Route::post('/account', [UsersController::class, 'account'])->name('user.updateAccount');

    // Show applicants
    Route::get('/group/{id}/member-applications', [DashboardController::class, 'showApplicants'])->name('group.member.applicants');

    // Send inivitations
    Route::post('/secret-group/apply', [DashboardController::class, 'addUsersToSecretGroups'])->name('secret.group.apply');

    // Show group members
    Route::get('/group/{id}/members', [DashboardController::class, 'groupMembers'])->name('group.member');

    // Accept members to a group
    Route::post('/group/{id}/accept-members', [DashboardController::class, 'accpetUsers'])->name('accept.members');

    // Remove members from a group
    Route::post('/group/{id}/remove-members', [DashboardController::class, 'removeMembers'])->name('remove.members');

    // Reject a user
    Route::post('/group/{id}/reject-member', [DashboardController::class, 'rejectApplicant'])->name('reject.members');

    // Show rejecred members
    Route::get('/group/{id}/rejected-members', [DashboardController::class, 'rejectUsers'])->name('group.member.rejected');

    // Unblock users
    Route::post('/group/{id}/unblock-member', [DashboardController::class, 'unblockUser'])->name('unblock.members');

    // Invitation page
    Route::get('/group/{id}/invite-member', [DashboardController::class, 'inviteUsers'])->name('invite.members');

    // Send invites
    Route::post('/send-invites', [DashboardController::class, 'sendInvites'])->name('send.invites');
});

// shared functionality
Route::middleware(['admin.mod.user'])->group(function () {
    // Media routes
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('dashboard.index');
    Route::post('/admin/dashboard/storeMedia', [DashboardController::class, 'storeMedia'])->name('dashboard.storeMedia');

    // Album/Category routes
    Route::post('/admin/storeCategory', [DashboardController::class, 'storeCategory'])->name('dashboard.storeCategory');
    Route::get('/admin/album/{category_id}', [DashboardController::class, 'categoryImages'])->name('dashboard.category.images');
        Route::get('/chat/{roomId?}', [App\Http\Controllers\Admin\ChatController::class, 'indexNew'])->name('chatNew');

    // Group routes
    Route::get('/admin/group', [DashboardController::class, 'group'])->name('dashboard.group');
    Route::post('/admin/createGroup', [DashboardController::class, 'createGroup'])->name('dashboard.createGroup');
    Route::get('/admin/group/{id}', [DashboardController::class, 'viewGroup'])->name('dashboard.group.view');
    Route::post('/admin/group/comment/{id}', [DashboardController::class, 'groupPostComments'])->name('dashboard.group.post.comment');
    Route::post('/group/comments/reply/{commentId}', [DashboardController::class, 'groupCommentReplies'])->name('group.post.comment.reply');
    Route::get('/admin/group/{groupId}/post/{postId}/comments', [DashboardController::class, 'showGroupComments'])->name('group.post.comments');
    Route::post('/admin/group/{id}/post', [DashboardController::class, 'postInGroup'])->name('dashboard.group.post');
    Route::get('/likeGroupPosts/{groupPostId}', [DashboardController::class, 'likeGroupPost']);
    Route::get('/likeGroupMedia/{groupPostId}', [DashboardController::class, 'toggleLikeGroupMedia']);
    Route::get('/liked-group-post-count/{groupPostId}', [DashboardController::class, 'likeGroupPostCount']);
    Route::get('/liked-group-media-count/{groupPostId}', [DashboardController::class, 'likeGroupMediaCount']);
    Route::post('/group/comments/edit/{commentId}', [DashboardController::class, 'editGroupComment'])->name('group.comments.edit');
    Route::delete('/group/comments/delete/{commentId}', [DashboardController::class, 'deleteGroupComment'])->name('group.comments.delete');
    Route::delete('/group/reply/delete/{replyId}', [DashboardController::class, 'deleteGroupReply'])->name('group.reply.delete');

    Route::get('/group-comment-like/{commentId}', [DashboardController::class, 'likeGroupComment'])->name('group.comment.like');
    Route::get('/group-comment-like-count/{commentId}', [DashboardController::class, 'groupCommentLikeCount']);

    // apply to a group
    Route::post('/group/apply', [DashboardController::class, 'userApplyToGroup'])->name('group.apply');

    // GIF route
    Route::post('/store-gif', [DashboardController::class, 'storeGif'])->name('store-gif');

    // Poll route
    Route::post('/store-poll', [DashboardController::class, 'storePoll'])->name('store-poll');
    Route::post('/polls/submit', [DashboardController::class, 'submitPoll'])->name('polls.submit');

    // Store post
    Route::post('/store-blog', [DashboardController::class, 'storePost'])->name('store-blog');

    // Store file
    Route::post('/store-file', [DashboardController::class, 'storeFile'])->name('store-file');

    // Blogs
    Route::get('/blog', [UsersController::class, 'blog'])->name('admin.blog');
    Route::post('/blog', [UsersController::class, 'blog'])->name('admin.blog.post');
    Route::get('/blog-view', [UsersController::class, 'viewBlog'])->name('admin.blog.view');
    Route::get('/blog-detail/{id}', [UsersController::class, 'blogDetail'])->name('admin.blog.detail');
    Route::get('/search-blog', [UsersController::class, 'search'])->name('blog.search');

    // Like and unlike
    Route::get('/like/{commentId}', [DashboardController::class, 'like'])->name('like');
    Route::get('/like-count/{commentId}', [DashboardController::class, 'getLikeCount']);

    // Post like
    Route::get('/toggle-like-post/{postId}', [DashboardController::class, 'togglePostLike']);
    Route::get('/post-like-count/{postId}', [DashboardController::class, 'getPostLikeCount'])->name('getPostLikeCount');

    // Poll like
    Route::get('/toggle-like-poll/{pollId}', [DashboardController::class, 'togglePollLike']);
    Route::get('/poll-like-count/{pollId}', [DashboardController::class, 'getPollLikeCount'])->name('getPollLikeCount');

    // File like
    Route::get('/toggle-like-file/{fileId}', [DashboardController::class, 'toggleFileLike']);
    Route::get('/file-like-count/{fileId}', [DashboardController::class, 'getFileLikeCount'])->name('getFileLikeCount');

    // Gif like
    Route::get('/toggle-like-gif/{gifId}', [DashboardController::class, 'toggleGifLike']);
    Route::get('/gif-like-count/{gifId}', [DashboardController::class, 'getGifLikeCount'])->name('getGifLikeCount');

    // Media like
    Route::get('/toggle-like-media/{batchNumber}', [DashboardController::class, 'toggleMediaLike']);
    Route::get('/media-like-count/{mediaId}', [DashboardController::class, 'getMediaLikeCount'])->name('getMediaLikeCount');

    // Notification page
    Route::get('/notification', [DashboardController::class, 'notification'])->name('notification');

    // Comment route
    Route::post('/comments/add/{commentableType}/{commentableId}', [DashboardController::class, 'addComment'])->name('comments.add');
    Route::post('/comments/edit/{commentId}', [DashboardController::class, 'editComment'])->name('comments.edit');
    Route::delete('/comments/delete/{commentId}', [DashboardController::class, 'deleteComment'])->name('comments.delete');
    Route::post('/comments/reply/{commentId}', [DashboardController::class, 'commentReplies'])->name('comments.reply');
    Route::post('/reply/edit/{replyId}', [DashboardController::class, 'editReply'])->name('reply.edit');
    Route::delete('/reply/delete/{replyId}', [DashboardController::class, 'deleteReply'])->name('reply.delete');

    // Plans routes
    Route::get('/plans-all', [App\Http\Controllers\Admin\PlansController::class, 'index'])->name('plans.index');
    Route::get('/plan/view/{id}', [App\Http\Controllers\Admin\PlansController::class, 'planDetails'])->name('plan.view');
    Route::get('/get-plans', [SubscriptionController::class, 'getPlans'])->name('get.plans');
    Route::post('/purchase-plan', [SubscriptionController::class, 'purchasePlan'])->name('purchase.plan');
    Route::post('/revoke-plan', [SubscriptionController::class, 'cancelPlan'])->name('revoke.plan');
});

Route::get('/admin/category', [DashboardController::class, 'category'])->name('dashboard.category');

// // Comment route
// Route::post('/comments/add/{commentableType}/{commentableId}', [DashboardController::class, 'addComment'])->name('comments.add');
// Route::post('/comments/edit/{commentId}', [DashboardController::class, 'editComment'])->name('comments.edit');
// Route::delete('/comments/delete/{commentId}', [DashboardController::class, 'deleteComment'])->name('comments.delete');
// Route::post('/comments/reply/{commentId}', [DashboardController::class, 'commentReplies'])->name('comments.reply');
// Route::post('/reply/edit/{replyId}', [DashboardController::class, 'editReply'])->name('reply.edit');
// Route::delete('/reply/delete/{replyId}', [DashboardController::class, 'deleteReply'])->name('reply.delete');

// // Plans routes
// Route::get('/plans-all', [App\Http\Controllers\Admin\PlansController::class, 'index'])->name('plans.index');
// Route::get('/plan/view/{id}', [App\Http\Controllers\Admin\PlansController::class, 'planDetails'])->name('plan.view');
// Route::get('/get-plans', [SubscriptionController::class, 'getPlans'])->name('get.plans');
// Route::post('/purchase-plan', [SubscriptionController::class, 'purchasePlan'])->name('purchase.plan');
// Route::post('/revoke-plan', [SubscriptionController::class, 'cancelPlan'])->name('revoke.plan');
