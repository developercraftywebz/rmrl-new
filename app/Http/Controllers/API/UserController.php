<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Enums\UserTypes;
use Hash;
use App\Mail\ForgotPasswordMail;
use App\Helpers\Media;
use App\Mail\UserRegistration;
use App\Models\AdminProfileImage;
use App\Models\Category;
use App\Models\ChatRoom;
use App\Models\CMS;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\CommentReply;
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
use App\Models\MediaLike;
use App\Models\Notification;
use App\Models\Poll;
use App\Models\PollSubmission;
use App\Models\Post;
use App\Models\ReplyLike;
use App\Models\Subscription;
use App\Models\UserComment;
use App\Models\UserGroup;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    private function generateOTP($otpDigits)
    {
        return rand(pow(10, $otpDigits - 1), pow(10, $otpDigits) - 1);
    }

    private function userAuthResponse($user, $params = [])
    {
        $token = $user->createToken('api-authentication')->accessToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => array_merge($user->getUserDisplayFields(), $params)
        ];
    }


    public function admin()
    {
        $admin = User::where('role_id', 3)->get();

        return [
            'admin' => $admin,

        ];
    }

    public function getAllGroupsComment()
    {
        $admin = User::where('role_id', 3)->get();

        return [
            'admin' => $admin,

        ];
    }




    private function handleUserFcmToken($user, $fcm_token)
    {
        $user->fcm_token = $fcm_token;
        $user->save();
    }

    public function register(Request $request)
    {
        try {
            $validation = [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
                'country_id' => 'numeric',
                'state_id' => 'numeric',
                'city_id' => 'numeric',
                'zip_code' => 'string',
                'contact_number' => 'required|max:255',
                'date_of_birth' => 'string',
            ];
            $validator = Validator::make($request->all(), $validation);
            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['otp'] = $this->generateOTP(4);
            $input['status'] = 0; // Account is inactive by default
            $input['role_id'] = UserTypes::User; // Account is type User
            $user = User::create($input);

            // Send mail to registered users
            Mail::to($user->email)->send(new UserRegistration($user));

            $response = [
                'status' => 200,
                'message' => 'Acccount almost created, kindly verify the OTP to complete the process!',
                'data' => $this->userAuthResponse($user)
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    
     public function likeComment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment_id' => 'required|exists:user_comments,id',
                'type' => 'sometimes|nullable|in:0,1', // 0 for dislike, 1 for like
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
    
            $user = auth()->user();
            $commentId = $request->input('comment_id');
    
            // Set a default value of '0' if 'type' is empty or not provided
            $type = $request->input('type');
    
            $comment = UserComment::find($commentId);
    
            if (!$comment) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Comment not found',
                ], 422);
            }
    
            // Check if the user has already liked/unliked the comment
            $existingLike = CommentLike::where('comment_id', $commentId)
                ->where('user_id', $user->id)
                ->first();
    
            if ($existingLike) {
                // If the like type is different, update the existing like record
                if ($existingLike->type != $type) {
                    // Update to 'like' when 1 is sent, otherwise update to 'dislike'
                    $existingLike->type = $type == '1' ? 'like' : 'dislike';
                    $existingLike->save();
                }
                // $action remains undefined as we are not deleting the existing like
            } else {
                // If no existing like record, create a new one
                CommentLike::create([
                    'comment_id' => $commentId,
                    'user_id' => $user->id,
                    'type' => $type == '1' ? 'like' : 'dislike',
                ]);
    
                $action = $type == '1' ? 'liked' : 'disliked';
            }
    
            return response()->json([
                'status' => 200,
                'message' => isset($action) ? "Comment $action successfully" : 'Existing like updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
    
    public function verification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => ['required', 'numeric'],
                'email' => ['required'],
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }
            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
            if ($user == null) {
                throw new \ErrorException("Invalid User");
            }
            if ($user->status == 1) {
                return response()->json([
                    'message' => "Your registration process is already completed!",
                ], 422);
            }
            // update user status to active
            $user->status = 1;
            $user->otp = $this->generateOTP(4);
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => "Registration process complete!",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }
    
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new \ErrorException('Invalid Credentials');
            }
    
            $user = Auth::user();
    
            $subscription = Subscription::where('user_id', $user->id)->where('stripe_status', 'active')->get();
    
            if ($user->status == 0) {
                throw new \ErrorException('Please verify your account');
            }
    
            if (isset($request->fcm_token)) {
                $this->handleUserFcmToken($user, $request->fcm_token);
            }
    
            $response = [
                'status' => 200,
                'message' => 'Successfully logged in',
                'data' => $this->userAuthResponse($user),
                'subscription' => $subscription, // Include subscription in the response
            ];
    
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    

    public function forgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->first();
            $otp = $this->generateOTP(4);

            if ($user == null) {
                throw new \ErrorException('User with this email does not exists');
            }
            // Send Email
            $body = [
                'name' => $user->first_name . " " . $user->last_name,
                'email' => $user->email,
                'otp' => $otp
            ];
            Mail::to($user->email)->send(new ForgotPasswordMail($body));
            $response = [
                'status' => 200,
                'message' => 'Forgot password request has been sent! Please check your mail for OTP verification',
                'otp' => $otp
            ];
            $user->update(['otp' => $otp]);
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getAllNotifications()
    {
        $notifications = Notification::all();

        return response()->json(['notifications' => $notifications]);
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|min:4|max:4',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if ($user == null) {
                throw new \ErrorException('Invalid Email or OTP');
            }

            $user->update([
                'password' => bcrypt($request->password),
                'otp' => $this->generateOTP(4)
            ]);

            $response = [
                'status' => 200,
                'message' => 'Your password has been reset!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function socialAuthentication(Request $request)
    {
        try {
            $validation = [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                'social_type' => 'required',
                'social_id' => 'required',
            ];

            if ($request->social_type == "apple") {
                unset($validation['first_name']);
                unset($validation['last_name']);
                unset($validation['email']);
            }

            $validator = Validator::make($request->all(), $validation);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            if ($request->social_type == "apple") {

                $tokenParts = explode(".", $request->social_id);
                $tokenPayload = base64_decode($tokenParts[1]);
                $jwtPayload = json_decode($tokenPayload);

                if (isset($jwtPayload->username)) {
                    $email = $jwtPayload->username;
                }

                if (isset($jwtPayload->email)) {
                    $email = $jwtPayload->email;
                }

                $first_name = explode("@", $email)[0];
                $last_name = explode("@", $email)[0];
            } else {
                $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
            }

            $new_account = false;
            $user = User::where('email', $email)->first();

            if ($user == null) {
                $user = new User();
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->email = $email;
                $user->password = bcrypt('admin123');
                $user->otp = $this->generateOTP(4);
                $user->status = 1; // Account is active by default
                $user->role_id = UserTypes::User; // Account is type User
                $user->save();

                $new_account = true;
            }

            if (isset($request->fcm_token)) {
                $this->handleUserFcmToken($user, $request->fcm_token);
            }

            User::where('id', $user->id)->update([
                'social_type' => $request->social_type,
                'social_id' => $request->social_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);

            $response = [
                'status' => 200,
                'message' => 'Successfully logged in',
                'data' => $this->userAuthResponse($user, [
                    'new_account' => $new_account
                ])
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke Token
            $res = $request->user()->token()->revoke();

            if ($res == null) {
                throw new \ErrorException('Something went wrong');
            }

            $response = [
                'status' => 200,
                'message' => "Successfully logged out"
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    
    public function editProfile(Request $request)
    {
        try {
            $user = $request->user();

            if ($request->has('first_name')) {
                $user->first_name = $request->first_name;
                $user->save();
            }

            if ($request->has('last_name')) {
                $user->last_name = $request->last_name;
                $user->save();
            }

            if ($request->has('email')) {
                $user->email = $request->email;
                $user->save();
            }

            if ($request->has('date_of_birth')) {
                $user->date_of_birth = $request->date_of_birth;
                $user->save();
            }

            if ($request->has('contact_number')) {
                $user->contact_number = $request->contact_number;
                $user->save();
            }

            if ($request->has('old_password') || $request->has('password')) {
                $validator = Validator::make($request->all(), [
                    'old_password' => 'required|min:6',
                    'password' => 'required|confirmed|min:6',
                ]);

                if ($validator->fails()) {
                    throw new \ErrorException($validator->errors()->first());
                }

                if (!Hash::check($request->old_password, $user->password)) {
                    throw new \ErrorException('Old password does not match');
                }

                $user->password = bcrypt($request->password);
                $user->save();
            }

            if ($request->has('country_id')) {
                $user->country_id = $request->country_id;
                $user->save();
            }

            if ($request->has('state_id')) {
                $user->state_id = $request->state_id;
                $user->save();
            }

            if ($request->has('city_id')) {
                $user->city_id = $request->city_id;
                $user->save();
            }

            if ($request->has('zip_code')) {
                $user->zip_code = $request->zip_code;
                $user->save();
            }
            $school_logo = $request->file('picture');

            if ($request->hasFile('picture')) {
                // Delete the old image
                $oldImage = public_path('images/users/' . $user->profile_picture);
                if (File::exists($oldImage)) {
                    $file = new File;
                    $file->delete($oldImage);
                }
            
                // Generate a unique identifier for the filename
                $uniqueIdentifier = uniqid();
            
                // Extract the file extension
                $extension = $school_logo->getClientOriginalExtension();
            
                // Combine the unique identifier and extension to create a short name
                $shortName = $uniqueIdentifier . '.' . $extension;
            
                // Move the file to the desired directory with the short name
                $school_logo->move(public_path('/images/users'), $shortName);
            
                // Set the profile_picture attribute with the correct URL
                $user->profile_picture = '/images/users/' . $shortName;
            
                // Save the user instance
                $user->save();
            }
            
            $response = [
                'status' => 200,
                'message' => "Details updated",
                'data' => [
                    'user' => $user->getUserDisplayFields(),
                ]
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function uploadPicture(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'picture' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $user = $request->user();
            $updatedUrl = $user->profile_picture;

            if ($request->has('picture')) {
                $updatedUrl = Media::profileAvatar($request->picture);
                $user->profile_picture = $updatedUrl;
                $user->save();
            }

            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    'profile_picture' => Media::convertFullUrl($updatedUrl)
                ]
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function createChatRoom(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $already_exists = false;

            $chatRoom = ChatRoom::where('author_id', $request->user()->id)->where('participant_id', $request->user_id)->first();

            if ($chatRoom == null) {
                $chatRoom = ChatRoom::where('author_id', $request->user_id)->where('participant_id', $request->user()->id)->first();
            }

            if ($chatRoom != null) {
                $already_exists = true;
            }

            if ($chatRoom == null) {
                $chatRoom = new ChatRoom();
                $chatRoom->author_id = $request->user()->id;
                $chatRoom->participant_id = $request->user_id;
                $chatRoom->status = 1;
                $chatRoom->save();
            }

            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    "already_exists" => $already_exists,
                    "room" => $chatRoom
                ]
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getAllChatsRooms(Request $request)
    {
        try {
            $rooms = ChatRoom::where(function ($query) use ($request) {
                $query->where('author_id', $request->user()->id)
                    ->orWhere('participant_id', $request->user()->id);
            })->orderby('updated_at', 'DESC')->get();

            $arr = [];

            foreach ($rooms as $room) {

                $author = $room->Author ? $room->Author->getUserDisplayFields() : null;
                $participant = $room->Participant ? $room->Participant->getUserDisplayFields() : null;

                array_push($arr, [
                    "id" => $room->id,
                    "status" => $room->status,
                    "created_at" => $room->created_at,
                    "updated_at" => $room->updated_at,
                    "user" => $room->author_id == $request->user()->id ? $participant : $author
                ]);
            }

            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    "rooms" => $arr
                ]
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getProfileDetails(Request $request)
    {
        try {
            $user = User::where('id', $request->user()->id)->with(['payments' => function ($e) {
                $e->select(['id', 'amount', 'user_id', "plan_id"])
                    ->with('plan')
                    ->select(['id', 'amount', 'user_id', "plan_id"]);
            }])->first();

            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    'user' => array_merge($user->getUserDisplayFields(), [
                        'payments' => $user->payments
                    ])
                ]
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // public function getMedia()
    // {
    //     try {
    //         $usersWithMedia = User::has('media')->with('media.userComments', 'media')->get();
    //         $usersResponse = $usersWithMedia->map(function ($user) {
    //             $mediaInfo = $user->media->groupBy('batch_number')->map(function ($mediaGroup, $batchNumber) use ($user) {
    //                 return [
    //                     'batch_number' => $batchNumber,
    //                     'media' => $mediaGroup->map(function ($media) {
    //                         return [
    //                             'media_id' => $media->id,
    //                             'file_path' => $media->file_path,
    //                             'file_type' => $media->file_type,
    //                         ];
    //                     }),
    //                     'comments' => UserComment::where('user_id', $user->id)
    //                         ->whereIn('media_id', $mediaGroup->pluck('batch_number')->all())
    //                         ->get()
    //                         ->map(function ($comment) {
    //                             return [
    //                                 'user_name' => $comment->user->first_name . ' ' . $comment->user->last_name,
    //                                 'user_id' => $comment->user->id,
    //                                 'user_profile_picture' => Media::convertFullUrl($comment->user->profile_picture),
    //                                 'user_comment' => $comment->comment,
    //                                 'media_id' => $comment->media_id,
    //                             ];
    //                         }),

    //                     'likes' => $this->getLikedMedia($batchNumber, $user->id),
    //                 ];
    //             });

    //             return [
    //                 'user_id' => $user->id,
    //                 'user_name' => $user->first_name . ' ' . $user->last_name,
    //                 'media_info' => $mediaInfo->values()->toArray(),
    //             ];
    //         });

    //         return response()->json([
    //             'status' => 200,
    //             'users' => $usersResponse,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 422,
    //             'message' => $e->getMessage(),
    //         ], 422);
    //     }
    // }
    public function getMedia()
    {
        try {
            $usersWithMedia = User::has('media')->with('media.userComments.user')->get();

            $usersResponse = $usersWithMedia->map(function ($user) {
                $mediaInfo = $user->media->groupBy('batch_number')->map(function ($mediaGroup, $batchNumber) use ($user) {
                    $batchNumbers = ModelsMedia::pluck('batch_number')->all();
                    $userComments = UserComment::whereIn('media_id', $batchNumbers)->get();

                    return [
                        'batch_number' => $batchNumber,
                        'media' => $mediaGroup->map(function ($media) {
                            return [
                                'media_id' => $media->batch_number,
                                'file_path' => $media->file_path,
                                'file_type' => $media->file_type,
                                'media_caption' => $media->media_caption,
                            ];
                        }),
                        'comments' => $userComments->filter(function ($comment) use ($mediaGroup) {
                            return $comment->media_id == $mediaGroup->first()->batch_number;
                        })->map(function ($comment) {
                            $commentUser = $comment->user;

                            return [
                                'user' => $commentUser, // Include complete user object
                                'user_comment' => $comment->comment,
                                'media_id' => $comment->media_id,
                            ];
                        })->values(), // Add this line to reindex the array numerically

                        'likes' => $this->getLikedMedia($mediaGroup->first()->batch_number, $user->id),
                    ];
                });

                return [
                    'user' => $user, // Include complete user object
                    'media_info' => $mediaInfo->values()->toArray(),
                ];
            });

            return response()->json([
                'status' => 200,
                'users' => $usersResponse,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    protected function getLikedMedia($batchNumber, $user_id)
    {
        // Get the liked images for the given batch_number
        $likedImages = LikePost::where('likeable_type', 'App\Models\Media')
            ->where('likeable_id', $batchNumber)
            ->with(['likeable', 'user:id,first_name,last_name,profile_picture'])
            ->get();

        $formattedLikedMedia = $likedImages->map(function ($like) use ($user_id) {
            if ($like->likeable instanceof \App\Models\Media) {
                return [
                    'media_id' => $like->likeable->id,
                    'user_id' => $like->user->id,
                    'user_name' => $like->user->first_name . ' ' . $like->user->last_name,
                    'profile_picture' => Media::convertFullUrl($like->user->profile_picture),
                    'is_liked' => true, // Assuming you want to indicate that it's liked
                    'liked_by_user' => $like->user_id == auth()->user()->id, // Indicates if the current user liked this media
                ];
            }

            return null;
        })->filter();

        return $formattedLikedMedia->toArray();
    }

    public function toggleLike(Request $request)
    {
        $user = $request->user();
        $batchNumber = $request->input('batchNumber');
        $isLiked = $request->input('isLiked');
        try {
            $mediaPost = ModelsMedia::where('batch_number', $batchNumber)->firstOrFail();
            $subscription = Subscription::where('user_id', $user->id)->first();
            $collectionIdentifier = $mediaPost->batch_number;
            $like = LikePost::where([
                'user_id' => $user->id,
                'likeable_id' => $collectionIdentifier,
                'likeable_type' => ModelsMedia::class
            ])->first();
            if (!$like && $isLiked) {
                // Create a like for the entire collection
                LikePost::create([
                    'user_id' => $user->id,
                    'likeable_id' => $collectionIdentifier,
                    'likeable_type' => ModelsMedia::class
                ]);
            } elseif ($like && !$isLiked) {
                $like->delete();
            } elseif ($like && $isLiked) {
                return response()->json([
                    'status' => 422,
                    'message' => 'You have already liked this media.'
                ], 422);
            } elseif (!$like && !$isLiked) {
                return response()->json([
                    'status' => 422,
                    'message' => 'You cannot unlike a media that you have not liked.'
                ], 422);
            }
            return response()->json([
                'status' => 200,
                'message' => $isLiked ? 'Like added successfully.' : 'Like removed successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

 public function mediaComment(Request $request)
{
    try {
        $media_batch_number = $request->input('media_batch_number');
        $media = ModelsMedia::where('batch_number', $media_batch_number)->first();
        
        if (!$media) {
            return response()->json([
                'status' => 422,
                'message' => 'Media not found'
            ], 422);
        }
        
        $user = auth()->user();
        
        $comment = UserComment::create([
            'user_id' => $user->id,
            'media_id' => $media_batch_number,
            'comment' => $request->input('comment'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Comment added successfully',
            'comment' => $comment, // Include the comment data in the response
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 422,
            'message' => $e->getMessage(),
        ], 422);
    }
}

    public function getMediaComments(Request $request)
    {
        try {
            $mediaId = $request->input('media_id');

            // Get authenticated user ID
            $userId = Auth::id();

            $mediaComments = UserComment::with(['user', 'commentLikes', 'commentReplies'])
                ->where('media_id', $mediaId)
                ->get()
                ->groupBy('user_id')
                ->map(function ($userComments) use ($userId) {
                    return $userComments->map(function ($comment) use ($userId) {
                        $user = $comment->user;

                        if ($user) {
                            $likesCount = $comment->commentLikes->count();
                            $isLikedByUser = $comment->commentLikes->where('user_id', $userId)->count() > 0;
                            $isLikedByUser = $comment->commentLikes
                                ->where('user_id', $userId)
                                ->whereIn('type', ['like', 'dislike']) // Consider both 'like' and 'dislike'
                                ->first();

                            // Include 'likes_count' and 'is_liked_by_user' inside the comment object
                            $commentData = [
                                'id' => $comment->id,
                                'user_id' => $comment->user_id,
                                'media_id' => $comment->media_id,
                                'comment' => $comment->comment,
                                'created_at' => $comment->created_at,
                                'updated_at' => $comment->updated_at,
                                'likes_count' => $likesCount,
                                'is_liked_by_user' => $isLikedByUser ? $isLikedByUser->type === 'like' : false, // true if liked, false otherwise

                            ];

                            // Include comment replies
                            $commentReplies = $comment->commentReplies->map(function ($reply) {
                                return [
                                    'id' => $reply->id,
                                    'user' => $reply->user, // This includes the complete User object
                                    'user_comment_id' => $reply->user_comment_id,
                                    'reply' => $reply->reply,
                                    'created_at' => $reply->created_at,
                                    'updated_at' => $reply->updated_at,
                                ];
                            });


                            return [
                                'comment' => array_merge($commentData, [
                                    'user' => array_filter(array_merge($user->getUserDisplayFields(), [
                                        'comment' => $user->comment, // Assuming you want to include user's comments
                                    ])),
                                    'comment_replies' => $commentReplies->toArray(),
                                ]),
                            ];
                        }
                    });
                })->collapse()->filter(); // Flatten the collection and remove null values

            return response()->json([
                'status' => 200,
                'comments' => $mediaComments->values()->toArray(), // Reset keys to remove grouping keys
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

 public function commentReply(Request $request)
    {
        try {
            $user = auth()->user();
            $userComment = UserComment::find($request->input('userCommentId'));
    
            if (!$userComment) {
                return response()->json([
                    'status' => 422,
                    'error' => 'User comment not found'
                ], 422);
            }
    
            $commentReply = CommentReply::create([
                'user_comment_id' => $userComment->id,
                'user_id' => $user->id,
                'reply' => $request->input('reply'),
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'Reply added successfully',
                'data' => [
                    'user_comment_id' => $userComment->id,
                    'user_id' => $user->id,
                    'reply_id' => $commentReply->id,
                    'reply' => $commentReply->reply,
                    'created_at' => $commentReply->created_at,
                    'updated_at' => $commentReply->updated_at,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    

    public function getCommentReplies()
    {
        try {
            $replies = CommentReply::with(['user', 'userComment'])->get();
            $formattedReplies = $replies->map(function ($reply) {
                return [
                    'user' => $reply->user->getUserDisplayFields(),
                    'comment' => $reply->userComment->comment,
                    'comment_id' => $reply->userComment->id,
                    'reply' => $reply->reply,
                ];
            });
            return response()->json([
                'status' => 200,
                'message' => $formattedReplies,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

public function toggleCommentLike(Request $request)
{
    try {
        $commentId = $request->input('commentId');
        $type = $request->input('type');

        $comment = CommentReply::find($commentId);
        $userComment = UserComment::find($commentId);

        if (!$comment || !$userComment) {
            return response()->json([
                'status' => 422,
                'error' => 'Comment not found',
            ], 422);
        }

        $loggedInUserId = auth()->id();
        $existingLike = CommentLike::where('comment_id', $commentId)
            ->where('')
            ->where('user_id', $loggedInUserId)
            ->first();

        if ($existingLike) {
            if ($existingLike->type === $type) {
                // If the like type is the same, delete the existing like record
                $existingLike->delete();
                $action = 'unliked';
            } else {
                // If the like type is different, update the existing like record
                $existingLike->type = $type;
                $existingLike->save();
                $action = $type ? 'liked' : 'unliked';
            }
        } else {
            // If no existing like record, create a new one
            CommentLike::create([
                'comment_id' => $commentId,
                'user_id' => $loggedInUserId,
                'type' => $type,
            ]);

            $action = $type ? 'liked' : 'unliked';
        }

        return response()->json([
            'status' => 200,
            'message' => "Comment $action successfully",
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 422,
            'message' => $e->getMessage(),
        ], 422);
    }
}


    public function getLikedComments()
    {
        try {
            // Retrieve comment likes with associated comment details
            $likedCommentsData = CommentLike::where('is_liked', true)
                ->with('comment') // Assuming a relationship named 'userComment' in the CommentLike model
                ->get();

            return response()->json([
                'status' => 200,
                'data' => [
                    'liked_comments' => $likedCommentsData,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function toggleReplyLike(Request $request)
    {
        try {
            $replyId = $request->input('replyId');
            $isLiked = $request->input('isLiked');
            $reply = CommentReply::find($replyId);
            if (!$reply) {
                return response()->json([
                    'status' => 422,
                    'error' => 'Reply not found'
                ], 422);
            }
            $loggedInUserId = auth()->id();
            $existingLike = ReplyLike::where('reply_id', $replyId)
                ->where('user_id', $loggedInUserId)
                ->first();
            if ($existingLike) {
                if ($existingLike->is_liked && !$isLiked) {
                    $existingLike->delete();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Reply unliked successfully'
                    ], 200);
                } elseif (!$existingLike->is_liked && $isLiked) {
                    $existingLike->is_liked = true;
                    $existingLike->save();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Reply liked successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 422,
                        'error' => 'Invalid action. You have already performed this action.'
                    ], 422);
                }
            } else {
                ReplyLike::create([
                    'reply_id' => $replyId,
                    'user_id' => $loggedInUserId,
                    'is_liked' => $isLiked,
                ]);
                $action = $isLiked ? 'liked' : 'disliked';
                return response()->json([
                    'status' => 200,
                    'message' => "Reply $action successfully"
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getReplyLikes()
    {
        try {
            $replyLikes = ReplyLike::with(['user', 'reply.userComment.user'])
                ->where('is_liked', true)
                ->get();

            $formattedLikes = $replyLikes->map(function ($like) {
                return [
                    'user' => $like->user->getUserDisplayFields(),
                    'reply' => [
                        'user' => $like->reply->user->getUserDisplayFields(),
                        'comment' => $like->reply->userComment->comment,
                        'reply_text' => $like->reply->reply,
                    ],
                ];
            });
            return response()->json([
                'status' => 200,
                'message' => $formattedLikes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getAllCategory()
    {
        try {
            $categories = Category::get();
            return response()->json([
                'status' => 200,
                'message' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getGroup()
    {
        try {
            $user = Auth::user();
            if ($user->role_id == UserTypes::Admin) {
                $groups = Group::get();
            } else {
                $groups = Group::where('privacy_type', '<>', 'Secret')->with('userGroups')->get();
            }
            return response([
                'status' => 422,
                'message' => $groups,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function combinedGroupPosts(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|integer|exists:groups,id',
                // Add more validation rules if needed
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Retrieve the 'id' from the request body
            $id = $request->input('group_id');

            // Retrieve regular posts excluding 'Image' and 'Video' types
            $regularPosts = GroupPost::with('user')
                ->where('group_id', $id)
                ->whereNotIn('type', ['Image', 'Video'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Retrieve media posts including 'Image' and 'Video' types
            $mediaPosts = GroupPost::with('user')
                ->where('group_id', $id)
                ->whereIn('type', ['Image', 'Video'])
                ->orderBy('created_at', 'desc')
                ->get();

            $authUserId = auth()->id();

            // Additional data for likes and comments for regular posts
            $regularPostsData = $regularPosts->map(function ($post) use ($authUserId) {
                $likes = GroupPostLike::where('post_id', $post->id)->get()->toArray();
                $comments = GroupPostComments::where('post_id', $post->id)->with('user')->get()->toArray();

                $totalLikesCount = count($likes);
                $authUserLiked = in_array($authUserId, array_column($likes, 'user_id'));

                // Modify each comment to include total likes count, auth user liked or not, and user object
                $modifiedComments = array_map(function ($comment) use ($authUserId, $totalLikesCount, $authUserLiked) {
                    $commentUser = $comment['user'];

                    return [
                        'total_likes_count' => $totalLikesCount,
                        'auth_user_liked' => $authUserLiked,
                        'user' => $commentUser,
                        'comment' => $comment,
                    ];
                }, $comments);

                return [
                    'type' => $post->type, // Dynamic type based on post type
                    'data' => [
                        'post' => $post,
                        'likes' => $likes,
                        'comments' => $modifiedComments,
                        'total_likes_count' => $totalLikesCount,
                        'auth_user_liked' => $authUserLiked,
                    ],
                ];
            });

            // Group media posts by media_batch_number
            $groupedMediaPosts = $mediaPosts->groupBy('media_batch_number')->map(function ($posts, $media_batch_number) use ($id) {
                $likesArray = $this->getMediaLikesArray($id, $media_batch_number); // Updated to use $id instead of $group->id
                $commentsArray = $this->getMediaCommentsArray($id, $media_batch_number); // Updated to use $id instead of $group->id

                return [
                    'type' => $posts->first()->type, // Dynamic type based on post type
                    'data' => [
                        'media_batch_number' => $media_batch_number,
                        'media_info' => $posts,
                        'likes' => $likesArray,
                        'comments' => $commentsArray,
                    ],
                ];
            })->values(); // Reset array keys to start from 0

            // Combine regular and media posts
            $combinedData = array_merge($regularPostsData->toArray(), $groupedMediaPosts->toArray());

            // Sort the combined data by created_at in descending order
            usort($combinedData, function ($a, $b) {
                $created_at_a = isset($a['data']['post']['created_at']) ? $a['data']['post']['created_at'] : null;
                $created_at_b = isset($b['data']['post']['created_at']) ? $b['data']['post']['created_at'] : null;

                if ($created_at_a && $created_at_b) {
                    return strtotime($created_at_b) - strtotime($created_at_a);
                } elseif ($created_at_a) {
                    return -1;
                } elseif ($created_at_b) {
                    return 1;
                }

                return 0;
            });

            $response = [
                'status' => 200,
                'message' => 'Data retrieved successfully',
                'data' => $combinedData,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    public function groupPost($id)
    {
        try {
            $group = Group::findOrFail($id);

            // Retrieve posts excluding 'Image' and 'Video' types
            $groupPosts = GroupPost::with('user')->where('group_id', $group->id)
                ->whereNotIn('type', ['Image', 'Video'])
                ->orderBy('created_at', 'desc')
                ->get();

            $authUserId = auth()->id();

            // Additional data for likes and comments
            $response = [
                'status' => 200,
                'data' => [
                    'groupPosts' => $groupPosts->map(function ($post) use ($authUserId) {
                        $likes = GroupPostLike::where('post_id', $post->id)->get()->toArray();
                        $comments = GroupPostComments::where('post_id', $post->id)->with('user')->get()->toArray();

                        $totalLikesCount = count($likes);
                        $authUserLiked = in_array($authUserId, array_column($likes, 'user_id'));

                        // Modify each comment to include total likes count, auth user liked or not, and user object
                        $modifiedComments = array_map(function ($comment) use ($authUserId, $totalLikesCount, $authUserLiked) {
                            $commentUser = $comment['user'];

                            return [
                                'total_likes_count' => $totalLikesCount,
                                'auth_user_liked' => $authUserLiked,
                                'user' => $commentUser,
                                'comment' => $comment,
                            ];
                        }, $comments);

                        return [
                            'post' => $post,
                            'likes' => $likes,
                            'comments' => $modifiedComments,
                            'total_likes_count' => $totalLikesCount,
                            'auth_user_liked' => $authUserLiked,
                        ];
                    }),
                ],
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function groupPostMedia(Request $request)
    {
        try {
            $request->validate([
                'group_id' => 'required|exists:groups,id',

            ]);

            $groupId = $request->input('group_id');
            $mediaBatchNumber = $request->input('media_batch_number');

            // Retrieve group details dynamically
            $group = Group::find($groupId);

            if (!$group) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Group not found.',
                ], 404);
            }

            // Retrieve posts excluding 'Image' and 'Video' types
            $groupPosts = GroupPost::with('user')->where('group_id', $group->id)

                ->whereIn('type', ['Image', 'Video'])
                ->orderBy('created_at', 'desc')
                ->get();


            // Group posts by media_batch_number
            $groupedPosts = $groupPosts->groupBy('media_batch_number')->map(function ($posts, $media_batch_number) use ($group) {
                $likesArray = $this->getMediaLikesArray($group->id, $media_batch_number);
                $commentsArray = $this->getMediaCommentsArray($group->id, $media_batch_number);

                return [
                    'media_batch_number' => $media_batch_number,
                    'media_info' => $posts,
                    'likes' => $likesArray,
                    'comments' => $commentsArray,
                ];
            })->values(); // Reset array keys to start from 0

            return response()->json([
                'status' => 200,
                'data' => $groupedPosts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    protected function getMediaLikesArray($groupId, $mediaBatchNumber)
    {
        // Check if the logged-in user has liked the post
        $isLiked = GroupPostLike::where('user_id', auth()->user()->id)
            ->where('group_id', $groupId)
            ->where('media_batch_number', $mediaBatchNumber)
            ->where('liked', true)
            ->exists();

        // Get likes by other users for the specific media_batch_number
        $likesArray = GroupPostLike::where('group_id', $groupId)
            ->where('media_batch_number', $mediaBatchNumber)
            ->where('liked', true)
            ->with(['user:id,first_name,last_name,profile_picture'])
            ->get();

        $likesArray = $likesArray->map(function ($like) {
            return [
                'user_id' => $like->user->id,
                'user_name' => $like->user->first_name . ' ' . $like->user->last_name,
                'profile_picture' => Media::convertFullUrl($like->user->profile_picture),
            ];
        })
            ->toArray();

        return [
            'is_liked' => $isLiked,
            'liked_by_user' => $likesArray,
        ];
    }


    protected function getMediaCommentsArray($postId)
    {
        $post = GroupPost::findOrFail($postId);
        if ($post->type == 'Image' || $post->type == 'Video') {
            // Retrieve comments for the specified group post
            $comments = GroupPostComments::where('group_id', $post->group_id)
                ->where('post_id', null) // Filter for media comments
                ->get();

            // Organize comments based on media_batch_number
            $commentData = [];

            foreach ($comments as $comment) {
                // Retrieve user data for each comment
                $userData = User::find($comment->user_id);
                // dd($userData);
                $commentData[] = [
                    'comment_id' => $comment->id,
                    'user_id' => $userData->id,
                    'username' => $userData->first_name . ' ' . $userData->last_name,
                    'profile_picture' => Media::convertFullUrl($userData->profile_picture),
                    'comment' => $comment->comment,
                    // Add any other user or comment-related data you need
                ];
            }

            // Return organized comment data
            return $commentData;
        } else {
            // If the post is not of type Image/Video, return an empty array
            return [];
        }
    }

    public function commentOnMediaPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|string|max:255',
                'media_batch_number' => [
                    'nullable',
                    'integer',
                    Rule::exists('group_posts', 'media_batch_number')->where('group_id', $request->input('group_id'))
                ],
                'group_id' => 'required|integer|exists:group_posts,group_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user_id = auth()->user()->id;
            $media_batch_number = $request->input('media_batch_number');
            $group_id = $request->input('group_id');

            // Find the group post based on media_batch_number and group_id
            $post = GroupPost::where('media_batch_number', $media_batch_number)
                ->where('group_id', $group_id)
                ->first();

            if (!$post) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Group post not found.',
                ], 404);
            }

            if ($post->type == 'Image' || $post->type == 'Video') {
                $comment = GroupPostComments::create([
                    'user_id' => $user_id,
                    'comment' => $request->input('comment'),
                    'group_id' => $group_id,
                    'post_id' => null,
                    'media_batch_number' => $media_batch_number,
                ]);

                $comment->save();

                // Return a JSON response for API
                return response()->json([
                    'status' => 200,
                    'message' => 'Comment posted successfully',
                ]);
            } else {
                // If the post is not of type Image/Video, return an appropriate response
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid request. This post is not of type Image or Video.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    public function getCommentsOnMediaPost($id)
    {
        try {
            $post = GroupPost::findOrFail($id);

            if ($post->type == 'Image' || $post->type == 'Video') {
                // Retrieve comments for the specified group post
                $comments = GroupPostComments::where('group_id', $post->group_id)
                    ->where('post_id', null) // Filter for media comments
                    ->get();

                // Organize comments based on media_batch_number
                $commentData = [];
                foreach ($comments as $comment) {
                    $mediaBatchNumber = $comment->media_batch_number ?? 'No Media Batch Number';

                    // Add a new array for media_batch_number if it doesn't exist
                    if (!isset($commentData[$mediaBatchNumber])) {
                        $commentData[$mediaBatchNumber] = [
                            'media_batch_number' => $mediaBatchNumber,
                            'comments' => [],
                        ];
                    }

                    // Retrieve user data for each comment
                    $userData = User::find($comment->user_id);
                    $commentData[$mediaBatchNumber]['comments'][] = [
                        'comment_id' => $comment->id,
                        'user_id' => $userData->id,
                        'username' => $userData->username,
                        'comment' => $comment->comment,
                        // Add any other user or comment-related data you need
                    ];
                }

                // Return a JSON response with the organized comment data
                return response()->json([
                    'status' => 200,
                    'data' => array_values($commentData),
                ]);
            } else {
                // If the post is not of type Image/Video, return an appropriate response
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid request. This post is not of type Image/Video.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function likeCommentOnMediaPost(Request $request)
    {
        try {
            // Validate the request, you may want to add more validation rules
            $request->validate([
                'user_id' => 'required|integer',
                'comment_id' => 'required|integer|exists:group_post_comments,id,user_id,' . $request->input('user_id'),
            ]);


            $user_id = $request->input('user_id');
            $comment_id = $request->input('comment_id');

            // Find the comment
            $comment = GroupPostComments::find($comment_id);

            // Check if the comment exists
            if (!$comment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Comment not found.',
                ], 404);
            }

            // Check if the user has already liked the comment
            $like = $comment->likes()->where('user_id', $user_id)->first();

            if (!$like) {
                // If not liked, add the like with media_batch_number and null post_id
                GroupPostCommentLike::create([
                    'user_id' => $user_id,
                    'comment_id' => $comment->id,
                    'group_id' => $comment->group_id,
                    'post_id' => null,
                    'media_batch_number' => $comment->media_batch_number,
                ]);

                // Return a JSON response for successful like
                return response()->json([
                    'status' => 200,
                    'message' => 'Comment liked successfully',
                ]);
            } else {
                // If the user has already liked the comment, delete the like record
                $like->delete();

                // Return a JSON response for successful unlike
                return response()->json([
                    'status' => 200,
                    'message' => 'Comment unliked successfully',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getAllCommentsOnGroupMedia(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|integer|exists:groups,id',
                'media_batch_number' => 'required|string', // Adjust the validation rule for media_batch_number as needed
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $group_id = $request->input('group_id');
            $media_batch_number = $request->input('media_batch_number');

            // Retrieve all comments for the specified group and media batch number
            $comments = GroupPostComments::where('group_id', $group_id)
                ->where('media_batch_number', $media_batch_number)
                ->where('parent_id', null) // Select only top-level comments
                ->with('user') // Eager load the user relationship
                ->orderBy('created_at', 'asc') // Adjust order as needed
                ->get();

            $authUserId = Auth::id();

            $commentsWithReplies = $comments->map(function ($comment) use ($group_id, $media_batch_number, $authUserId) {
                $replies = GroupPostComments::where('group_id', $group_id)
                    ->where('media_batch_number', $media_batch_number)
                    ->where('parent_id', $comment->id)
                    ->with('user') // Eager load the user relationship
                    ->orderBy('created_at', 'asc') // Adjust order as needed
                    ->get();

                // Determine if the authenticated user has liked the comment
                $comment->auth_user_liked = $comment->likes()->where('user_id', $authUserId)->exists();

                // Determine if the authenticated user has liked each reply
                $replies = $replies->map(function ($reply) use ($authUserId) {
                    $reply->auth_user_liked = $reply->likes()->where('user_id', $authUserId)->exists();
                    return $reply;
                });

                $comment->replies = $replies;

                return $comment;
            });

            // Return a JSON response for API
            return response()->json([
                'status' => 200,
                'data' => $commentsWithReplies,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function commentOnGroupPost(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'comment' => 'required|string|max:255',
                    'media_batch_number' => 'nullable|integer',
                    'group_id' => 'required|integer|exists:group_posts,group_id',
                    'post_id' => [
                        'required',
                        'integer',
                        Rule::exists('group_posts', 'id')->where(function ($query) {
                            $query->whereNotIn('type', ['Image', 'Video']);
                        }),
                    ],
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 422,
                        'message' => $validator->errors()->first(),
                    ], 422);
                }

                $user_id = auth()->user()->id;
                $post = GroupPost::findOrFail($request->input('post_id'));

                if ($post->type == 'Image' || $post->type == 'Video') {
                    // If the post is not of type Image/Video, return an appropriate response
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid request. This post is not of type Image or Video.',
                    ]);
                }

                $comment = GroupPostComments::create([
                    'user_id' => $user_id,
                    'comment' => $request->input('comment'),
                    'group_id' => $request->input('group_id'),
                    'post_id' => $request->input('post_id'),
                    'media_batch_number' => $request->input('media_batch_number'),
                ]);

                $comment->save();

                // Return a JSON response for API
                return response()->json([
                    'status' => 200,
                    'message' => 'Comment posted successfully',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function replyToCommentOnGroupPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|string|max:255',
                'group_id' => 'required|integer|exists:group_posts,group_id',
                'post_id' => [
                    'required',
                    'integer',
                    Rule::exists('group_posts', 'id')->where(function ($query) use ($request) {
                        $query->where('group_id', $request->input('group_id'))
                            ->whereNotIn('type', ['Image', 'Video']);
                    }),
                ],
                'parent_id' => [
                    'required',
                    'integer',
                    Rule::exists('group_post_comments', 'id')->where(function ($query) use ($request) {
                        $query->where('group_id', $request->input('group_id'))
                            ->where('post_id', $request->input('post_id'));
                    }),
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user_id = auth()->user()->id;

            $reply = GroupPostComments::create([
                'user_id' => $user_id,
                'comment' => $request->input('comment'),
                'group_id' => $request->input('group_id'),
                'post_id' => $request->input('post_id'),
                'parent_id' => $request->input('parent_id'),
            ]);

            $reply->save();

            // Return a JSON response for API
            return response()->json([
                'status' => 200,
                'message' => 'Reply posted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function getAllCommentsAndRepliesForPost(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|integer|exists:groups,id',
                'post_id' => 'required|integer|exists:group_posts,id',
                // You may add additional validation rules if needed
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $group_id = $request->input('group_id');
            $post_id = $request->input('post_id');

            // Retrieve all top-level comments for the specified post
            $comments = GroupPostComments::where('group_id', $group_id)
                ->where('post_id', $post_id)
                ->where('parent_id', null) // Select only top-level comments
                ->with('user') // Eager load the user relationship
                ->orderBy('created_at', 'asc') // Adjust order as needed
                ->get();

            $commentsWithReplies = $comments->map(function ($comment) {
                // Retrieve replies for each comment
                $replies = GroupPostComments::where('parent_id', $comment->id)
                    ->with('user') // Eager load the user relationship
                    ->orderBy('created_at', 'asc') // Adjust order as needed
                    ->get();

                $comment->replies = $replies;

                // Check if the authenticated user has liked the comment
                $comment->auth_user_liked = $comment->likes()->where('user_id', auth()->id())->exists();

                // Check if the authenticated user has liked each reply
                $comment->replies->each(function ($reply) {
                    $reply->auth_user_liked = $reply->likes()->where('user_id', auth()->id())->exists();
                });

                return $comment;
            });

            // Return a JSON response for API
            return response()->json([
                'status' => 200,
                'data' => $commentsWithReplies,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }



     public function replyToCommentOnGroupMedia(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|string|max:255',
                'group_id' => 'required|integer|exists:group_posts,group_id',
                'media_batch_number' => [
                    'required',
                    'integer',
                    Rule::exists('group_post_comments', 'media_batch_number')->where(function ($query) use ($request) {
                        $query->where('group_id', $request->input('group_id'));
                    }),
                ],
                'parent_id' => [
                    'required',
                    'integer',
                    Rule::exists('group_post_comments', 'id')->where(function ($query) use ($request) {
                        $query->where('group_id', $request->input('group_id'))
                            ->where('media_batch_number', $request->input('media_batch_number'));
                    }),
                ],
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
    
            $user_id = auth()->user()->id;
    
            $reply = GroupPostComments::create([
                'user_id' => $user_id,
                'comment' => $request->input('comment'),
                'group_id' => $request->input('group_id'),
                'media_batch_number' => $request->input('media_batch_number'),
                'parent_id' => $request->input('parent_id'),
            ]);
    
            // Retrieve the reply with additional details if needed
            $replyWithDetails = GroupPostComments::with('user')->find($reply->id);
    
            // Return a JSON response with data
            return response()->json([
                'status' => 200,
                'message' => 'Reply posted successfully',
                'data' => $replyWithDetails,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }





      public function getCombinedData()
    {
        try {
            $authUserId = Auth::id();
    
            // Retrieve media directly from the Media model
            $mediaPosts = ModelsMedia::with('userComments', 'user')->get();
    
            // Process Media Posts
            $mediaInfo = $mediaPosts->groupBy('batch_number')->map(function ($mediaGroup, $batchNumber) {
                $batchNumbers = ModelsMedia::pluck('batch_number')->all();
                $userComments = UserComment::whereIn('media_id', $batchNumbers)->get();
    
                return [
                    'media' => [
                        'batch_number' => $batchNumber,
                        'media_info' => $mediaGroup->map(function ($media) {
                            return [
                                'media_id' => $media->batch_number,
                                'file_path' => $media->file_path,
                                'user_id' => $media->user->id, // Include user_id in media
                                'user' => $media->user, // Include complete user object in media
                                'file_type' => $media->file_type,
                                'media_caption' => $media->media_caption,
                                'created_at' => $media->created_at,
                            ];
                        }),
                        'comments' => $userComments->filter(function ($comment) use ($mediaGroup) {
                            return $comment->media_id == $mediaGroup->first()->batch_number;
                        })->map(function ($comment) {
                            $commentUser = $comment->user;
    
                            return [
                                'user' => $commentUser, // Include complete user object
                                'user_comment' => $comment->comment,
                                'media_id' => $comment->media_id,
                                'created_at' => $comment->created_at,
                            ];
                        })->values(), // Add this line to reindex the array numerically
                        'likes' => $this->getLikedMedia($mediaGroup->first()->batch_number, $mediaGroup->first()->user_id),
                    ]
                ];
            });
    
            // Process Text, Gif, and Poll Posts
            $gif = Gif::with(['comments', 'likes', 'user'])->get();
            $textPost = Post::with(['likes', 'comments', 'user'])->get();
            $polls = Poll::with(['comments', 'likes', 'pollSubmissions'])->get();
    
            $nonMediaData = [];
    
            foreach ($gif as $item) {
                $likesCount = $item->likes->count();
                $isLikedByUser = $item->likes->where('user_id', $authUserId)->count() > 0;
    
                $nonMediaData[] = [
                    'type' => 'gif',
                    'data' => $item,
                    'likes_count' => $likesCount,
                    'is_liked_by_user' => $isLikedByUser,
                    'created_at' => $item->created_at, // Add this line to include the 'created_at' timestamp
                ];
            }
    
            foreach ($textPost as $item) {
                $likesCount = $item->likes->count();
                $isLikedByUser = $item->likes->where('user_id', $authUserId)->count() > 0;
    
                $nonMediaData[] = [
                    'type' => 'text post',
                    'data' => $item,
                    'likes_count' => $likesCount,
                    'is_liked_by_user' => $isLikedByUser,
                    'created_at' => $item->created_at, // Add this line to include the 'created_at' timestamp
                ];
            }
    
            foreach ($polls as $poll) {
                $totalSubmissions = $poll->pollSubmissions->count();
                $percentages = [];
                $optionCounts = [];
    
                foreach ($poll->pollSubmissions as $submission) {
                    $selectedOptions = json_decode($submission->selected_options, true);
    
                    foreach ($selectedOptions as $option) {
                        // Increment the count for each option
                        if (!isset($optionCounts[$option])) {
                            $optionCounts[$option] = 0;
                        }
    
                        $optionCounts[$option]++;
                    }
                }
    
                // Calculate percentages
                foreach ($optionCounts as $option => &$count) {
                    $percentage = $totalSubmissions > 0 ? ($count / $totalSubmissions) * 100 : 0;
                    $count = $percentage;
                }
    
                $nonMediaData[] = [
                    'type' => 'poll',
                    'data' => [
                        'poll' => $poll,
                        'option_counts' => $optionCounts,
                        'percentages' => $percentages,
                    ],
                    'created_at' => $poll->created_at, // Add this line to include the 'created_at' timestamp
                ];
            }
    
            // Merge all data and sort by created_at in descending order
            $combinedData = array_merge($mediaInfo->values()->toArray(), $nonMediaData);
            usort($combinedData, function ($a, $b) {
                $created_at_a = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
                $created_at_b = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
    
                // Use the combined timestamp (date and time) for comparison
                return $created_at_b - $created_at_a;
            });
    
            return response()->json(['data' => $combinedData], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    
    

    
    
    





    public function allPosts()
    {
        try {
            $authUserId = Auth::id();

            // Retrieve all posts with their comments
            $gif = Gif::with(['comments', 'likes', 'user'])->orderBy('created_at', 'desc')->get();
            $textPost = Post::with(['likes', 'comments', 'user'])->orderBy('created_at', 'desc')->get();
            $polls = Poll::with(['comments', 'likes', 'pollSubmissions'])->get();

            $posts = [];

            foreach ($gif as $item) {
                $likesCount = $item->likes->count();
                $isLikedByUser = $item->likes->where('user_id', $authUserId)->count() > 0;

                $posts[] = [
                    'type' => 'gif',
                    'data' => $item,
                    'likes_count' => $likesCount,
                    'is_liked_by_user' => $isLikedByUser,
                ];
            }

            foreach ($textPost as $item) {
                $likesCount = $item->likes->count();
                $isLikedByUser = $item->likes->where('user_id', $authUserId)->count() > 0;

                $posts[] = [
                    'type' => 'text post',
                    'data' => $item,
                    'likes_count' => $likesCount,
                    'is_liked_by_user' => $isLikedByUser,
                ];
            }

            foreach ($polls as $poll) {
                $totalSubmissions = $poll->pollSubmissions->count();
                $percentages = [];
                $optionCounts = [];

                foreach ($poll->pollSubmissions as $submission) {
                    $selectedOptions = json_decode($submission->selected_options, true);

                    foreach ($selectedOptions as $option) {
                        // Increment the count for each option
                        if (!isset($optionCounts[$option])) {
                            $optionCounts[$option] = 0;
                        }

                        $optionCounts[$option]++;

                        // Increment the count for calculating percentages
                        if (!isset($percentages[$option])) {
                            $percentages[$option] = 0;
                        }

                        $percentages[$option]++;
                    }
                }

                // Calculate percentages
                foreach ($percentages as $option => &$count) {
                    $percentage = $totalSubmissions > 0 ? ($count / $totalSubmissions) * 100 : 0;
                    $count = $percentage;
                }

                $posts[] = [
                    'type' => 'poll',
                    'data' => [
                        'poll' => $poll,
                        'option_counts' => $optionCounts,
                        'percentages' => $percentages,
                    ],
                ];
            }
            return response()->json(['posts' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function submitPoll(Request $request)
    {
        try {
            $pollId = $request->input('pollId');
            $user = Auth::user();
            if ($user->pollSubmissions->contains('poll_id', $pollId)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'You have already submitted this poll.'
                ], 422);
            }
            $poll = Poll::find($pollId);
            if (!$poll) {
                return response()->json([
                    'status' => 422,
                    'message' => 'This poll does not exist'
                ], 422);
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
            return response()->json([
                'status' => 200,
                'message' => 'Your answer has been submitted successfully',
                'data' => $answer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Comments like/unlike and count
    public function like($commentId)
    {
        try {
            $user = Auth::user();
            $comment = Comment::find($commentId);
            if (!$comment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Comment not found.',
                ], 404);
            }
            $like = Like::where(['user_id' => $user->id, 'comment_id' => $comment->id])->first();
            if (!$like) {
                $user->likes()->create(['comment_id' => $comment->id]);
            } else {
                $like->delete();
            }
            return response()->json([
                'status' => 200,
                'message' => $like ? 'Comment unliked successfully' : 'Comment liked successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getLikeCount($commentId)
    {
        try {
            $likeCount = Like::where('comment_id', $commentId)->count();
            return response()->json([
                'status' => 200,
                'likeCount' => $likeCount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Post like/unlike and count
    public function postLike($postId)
    {
        try {
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
            return response()->json([
                'status' => 200,
                'message' => $like ? 'Post unliked successfully' : 'Post liked successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function postLikeCount($postId)
    {
        try {
            $postLikeCount = LikePost::where('likeable_type', Post::class)
                ->where('likeable_id', $postId)
                ->count();
            return response()->json([
                'status' => 200,
                'postLikeCount' => $postLikeCount,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Poll like/unlike and count
    public function pollLike($pollId)
    {
        try {
            $user = Auth::user();
            $textPost = Poll::findOrFail($pollId);
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
            return response()->json([
                'status' => 200,
                'message' => $like ? 'Poll unliked successfully' : 'Poll liked successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function pollLikeCount($pollId)
    {
        try {
            $pollLikeCount = LikePost::where('likeable_type', Poll::class)
                ->where('likeable_id', $pollId)
                ->count();
            return response()->json([
                'status' => 200,
                'pollLikeCount' => $pollLikeCount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Gifs like/unlike and count
    public function gifLike($gifId)
    {
        try {
            $user = Auth::user();
            $textPost = Gif::findOrFail($gifId);
            $like = LikePost::where(['user_id' => $user->id, 'likeable_id' => $textPost->id, 'likeable_type' => Gif::class])->first();
            if (!$like) {
                $textPost->likes()->create(['user_id' => $user->id]);
            } else {
                $like->delete();
            }
            return response()->json([
                'status' => 200,
                'message' => $like ? 'Gif unliked successfully' : 'Gif liked successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function gifLikeCount($gifId)
    {
        try {
            $gifLikeCount = LikePost::where('likeable_type', Gif::class)
                ->where('likeable_id', $gifId)
                ->count();
            return response()->json([
                'status' => 200,
                'gifLikeCount' => $gifLikeCount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function likeGroupPost($postId)
    {
        try {
            $user = Auth::user();
            $groupPost = GroupPost::whereNotIn('type', ['Image', 'Video'])
                ->find($postId);

            if (!$groupPost) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Group post not found.',
                ], 404);
            }

            $existingLike = GroupPostLike::where([
                'user_id' => $user->id,
                'post_id' => $postId,
            ])->first();

            if ($existingLike) {
                $existingLike->delete();
                $groupPost->decrement('likes');
                $liked = false;
                return response()->json([
                    'status' => 200,
                    'message' => "Post has been unliked.",
                ], 200);
            } else {
                $data = GroupPostLike::create([
                    'user_id' => $user->id,
                    'post_id' => $postId,
                    'group_id' => $groupPost->group_id,
                    'liked' => true,
                ]);

                $groupPost->increment('likes');
                $liked = true;
                return response()->json([
                    'status' => 200,
                    'message' => "Post has been liked.",
                    'data' => $data,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function likeGroupPostCount($postId)
    {
        $groupPost = GroupPost::whereNotIn('type', ['Image', 'Video'])->find($postId);
        $likesCount = $groupPost->likes;
        return response()->json([
            'status' => 200,
            'data' => $likesCount
        ]);
    }

    // Apply to a group
    public function userApplyToGroup(Request $request)
    {
        try {
            $user = Auth::user();
            $groupId = $request->input('id');
            $existingApplication = UserGroup::where('user_id', $user->id)
                ->where('group_id', $groupId)
                ->first();

            if ($existingApplication) {
                return response()->json([
                    'status' => 400,
                    'message' => 'You have already applied to this group.',
                ], 400);
            }
            $data = UserGroup::create([
                'user_id' => $user->id,
                'group_id' => $groupId,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Application submitted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Like/unlike group post media
    public function toggleLikeGroupMedia(Request $request)
    {
        try {
            $user = $request->user();

            $request->validate([
                'group_id' => 'required|exists:groups,id',
                'media_batch_number' => 'required|string',
            ]);

            $groupId = $request->input('group_id');
            $mediaBatchNumber = $request->input('media_batch_number');

            // Check if the user already liked the media batch
            $existingLike = GroupPostLike::where([
                'user_id' => $user->id,
                'group_id' => $groupId,
                'media_batch_number' => $mediaBatchNumber,
            ])->first();

            if ($existingLike) {
                // User already liked, toggle the liked status
                $newLikeStatus = !$existingLike->liked;

                $existingLike->update([
                    'liked' => $newLikeStatus,
                ]);

                // Update the likes count for all media posts in the batch
                GroupPost::where('group_id', $groupId)
                    ->where('media_batch_number', $mediaBatchNumber)
                    ->whereIn('type', ['Image', 'Video'])
                    ->update(['likes' => $newLikeStatus]);

                return response()->json([
                    'status' => 200,
                    'message' => $newLikeStatus ? 'Media has been liked.' : 'Media has been unliked.',
                    'is_liked' => $newLikeStatus ? 1 : 0,
                ], 200);
            } else {
                // User hasn't liked, like the media batch
                $groupPost = GroupPost::where('group_id', $groupId)
                    ->where('media_batch_number', $mediaBatchNumber)
                    ->whereIn('type', ['Image', 'Video'])
                    ->first();

                if (!$groupPost) {
                    // Handle case where the group_post entry does not exist
                    return response()->json([
                        'status' => 404,
                        'message' => 'Group post not found.',
                    ], 404);
                }

                // Create GroupPostLike and associate it with group_id
                GroupPostLike::create([
                    'user_id' => $user->id,
                    'group_id' => $groupId,
                    'media_batch_number' => $mediaBatchNumber,
                    'liked' => true,
                ]);

                // Increment the likes count for all media posts in the batch
                $groupPost->increment('likes');

                return response()->json([
                    'status' => 200,
                    'message' => 'Media has been liked.',
                    'is_liked' => 1,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }





    public function likeGroupMediaCount($postId)
    {
        $groupPost = GroupPost::whereIn('type', ['Image', 'Video'])->find($postId);
        $likesCount = $groupPost->likes;
        return response()->json([
            'status' => 200,
            'data' => $likesCount
        ]);
    }



}
