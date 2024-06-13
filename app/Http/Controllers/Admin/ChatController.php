<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Media;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function uploadAttachment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'media' => 'required',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $asset_url = null;
            if ($request->has('media')) {
                $asset_url = Media::uploadAttachment($request->media);
            }

            $response = [
                'status' => 200,
                'message' => "attachment has been uploaded",
                'data' => [
                    "media_url" => asset($asset_url)
                ]
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            $response = [
                'status' => 422,
                'message' => $e->getMessage(),
                'data' => []
            ];

            return response()->json($response, 422);
        }
    }
    public function index(Request $request, $roomId = null)
    {
        // Get all users with role ID 2 (assuming role ID 2 represents participants)
        $users = User::where('role_id', 2)->get();
        
        // Iterate through each participant user
        foreach ($users as $user) {
            // Check if a chat room already exists between the current user and the participant
            $newChatRoom = Chat::where(function ($query) use ($user) {
                                $query->where('author_id', auth()->user()->id)
                                      ->where('participant_id', $user->id);
                            })
                            ->orWhere(function ($query) use ($user) {
                                $query->where('author_id', $user->id)
                                      ->where('participant_id', auth()->user()->id);
                            })
                            ->exists();
        
            if (!$newChatRoom) {
                $newChatRoom = new Chat();
                $newChatRoom->author_id = auth()->user()->id;
                $newChatRoom->participant_id = $user->id;
                $newChatRoom->save();
            }
        }
        
        $selectedRoom = Chat::where('id', $roomId)->first();
        $attachment = "";
        
        if ($request->agent_id && $request->attachment) {
            $checkRoom = Chat::where('author_id', $request->user()->id)
                            ->where('participant_id', $request->agent_id)
                            ->first();
        
            if ($checkRoom == null) {
                $checkRoom = Chat::where('author_id', $request->agent_id)
                                ->where('participant_id', $request->user()->id)
                                ->first();
            }
        
            if ($checkRoom == null) {
                $checkRoom = new Chat();
                $checkRoom->author_id = $request->user()->id;
                $checkRoom->participant_id = $request->agent_id;
                $checkRoom->status = 1;
                $checkRoom->save();
            }
        
            $selectedRoom = $checkRoom;
            $attachment = $request->attachment;
        }
        
        $sender_id = $request->user()->id;
        $reciever_id = $selectedRoom != null ? ($selectedRoom->author_id == $sender_id ? $selectedRoom->participant_id : $selectedRoom->author_id) : 0;
        
        $participants = $selectedRoom ? [$selectedRoom->Author->getUserDisplayFields(), $selectedRoom->Participant->getUserDisplayFields()] : [];
        
        $rooms = Chat::where('author_id', $request->user()->id)
                    ->orWhere('participant_id', $request->user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        
        return view('admin.admin-notes', [
            "rooms" =>  $rooms,
            "sender_id" => $sender_id,
            "reciever_id" => $reciever_id,
            "selected_room" => $selectedRoom,
            "participants" => $participants,
            "attachment" => $attachment
        ]);
    }
    

    public function indexNew(Request $request)
    {
        // Fetch the user with role_id 1
        $user = User::where('role_id', 1)->first();
    
        // Check if a chat room exists between the authenticated user and the selected user
        $selectedRoom = Chat::where(function ($query) use ($user) {
                            $query->where('author_id', auth()->user()->id)
                                  ->where('participant_id', $user->id);
                        })
                        ->orWhere(function ($query) use ($user) {
                            $query->where('author_id', $user->id)
                                  ->where('participant_id', auth()->user()->id);
                        })
                        ->first();
    
        // If no chat room exists, create a new one
        if (!$selectedRoom) {
            $selectedRoom = new Chat();
            $selectedRoom->author_id = auth()->user()->id;
            $selectedRoom->participant_id = $user->id;
            $selectedRoom->save();
        }
    
        // Fetch sender_id and reciever_id
        $sender_id = $request->user()->id;
        $reciever_id = $selectedRoom->author_id == $sender_id ? $selectedRoom->participant_id : $selectedRoom->author_id;
    
        // Fetch participants' details
        $participants = [$selectedRoom->Author->getUserDisplayFields(), $selectedRoom->Participant->getUserDisplayFields()];
    
        // Fetch all chat rooms for the authenticated user
        $rooms = Chat::where('author_id', $request->user()->id)
                    ->orWhere('participant_id', $request->user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    
        return view('admin.chat', [
            "rooms" =>  $rooms,
            "sender_id" => $sender_id,
            "reciever_id" => $reciever_id,
            "selected_room" => $selectedRoom,
            "participants" => $participants,
            "attachment" => ""
        ]);
    }
    
    
    
    
    
}
