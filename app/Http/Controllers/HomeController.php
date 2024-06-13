<?php

namespace App\Http\Controllers;

use App\Models\AdminProfileImage;
use App\Models\Category;
use App\Models\File;
use App\Models\Gif;
use App\Models\Group;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Post;
use App\Models\User;
use FCM;
use Brozot\LaravelFcm\FcmMessage;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index(Request $request)
     {
         $apiKey = env('GIPHY_PUBLIC_KEY');
     
         // Define the Giphy API endpoint
         $endpoint = $request->input('search_query')
             ? 'https://api.giphy.com/v1/gifs/search'
             : 'https://api.giphy.com/v1/gifs/trending';
     
         // Get the user's search query from the request
         $searchQuery = $request->input('search_query');
     
         // Define the number of GIFs to retrieve (you can adjust this as needed)
         $limit = 10;
     
         // Build the request parameters based on whether a search query is provided
         $params = [
             'api_key' => $apiKey,
             'limit' => $limit,
         ];
     
         if ($searchQuery) {
             $params['q'] = $searchQuery;
         }
     
         // Check if the user has an FCM token
         $user = auth()->user();
     
         if ($user->fcm_token) {
             // Example usage of sendPushNotification
             $title = 'New Post/Media Created';
             $message = 'An admin has created a new post or media. Check it out!';
             $responsedata = ['type' => 'post_media_notification'];
             $user_type = 'admin';
     
             // Call the function to send push notification
             $notificationResult = sendPushNotification($user, $title, $message, $responsedata, $user_type);
     
             // Check if there was an error in sending the notification
             if (is_array($notificationResult) && array_key_exists('error', $notificationResult)) {
                 // Handle notification sending failure
                 // You can log the error or return a response to the user
                 return response()->json(['error' => $notificationResult['error']], 500);
             }
         }
     
         // Continue with your existing logic...
         $gifs = [];
         
         // Order categories by created_at in descending order (latest first)
         $categories = Category::orderBy('created_at', 'desc')->get();
         
         // Order text posts by created_at in descending order (latest first)
         $textPosts = Post::orderBy('created_at', 'desc')->latest()->get();
         
         // Order category media by created_at in descending order (latest first)
         $categoryMedia = Category::with(['media' => function ($query) {
             $query->orderBy('created_at', 'desc');
         }])->get();
         
         // Order groups by created_at in descending order (latest first)
         $groups = Group::orderBy('created_at', 'desc')->latest()->get();
         
         // Order polls by created_at in descending order (latest first)
         $polls = Poll::with('comments')->orderBy('created_at', 'desc')->latest()->get();
         
         // Order files by created_at in descending order (latest first)
         $files = File::with('comments')->orderBy('created_at', 'desc')->latest()->get();
         
         // Order GIFs by created_at in descending order (latest first)
         $gif = Gif::with('comments')->orderBy('created_at', 'desc')->latest()->get();
     
         // Retrieve the records without batch number grouping
         // Order media by created_at in descending order (latest first)
         $media = Media::with(['comments', 'user'])
             ->orderBy('created_at', 'desc')->latest()
             ->get();
     
         // Now, apply the grouping by batch number
         $media_with_batch = $media->sortByDesc('created_at')->groupBy('batch_number');
     
         // Order admin profile images by created_at in descending order (latest first)
         $adminProfileImages = AdminProfileImage::orderBy('created_at', 'desc')->get();
         
         // Get distinct users who posted media
         $distinctMediaUsers = Media::select('user_id')->distinct()->pluck('user_id');
         
         // Get users based on distinct media user IDs
         $mediaUsers = User::whereIn('id', $distinctMediaUsers)->get();
     
         return view('profile', compact('categories', 'gifs', 'categoryMedia', 'groups', 'polls', 'files', 'textPosts', 'gif', 'adminProfileImages', 'mediaUsers', 'media_with_batch', 'media'));
     }
     
     
     
}
