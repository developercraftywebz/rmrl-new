@extends('layouts.dashboard')


@section('content')
@php
use App\Models\User;
use App\Helpers\Media;



$users = User::where('role_id', 1)->orderBy('created_at', 'desc')->get();
@endphp
<style>

.content-page {
    margin-left: 123px;
    overflow: hidden;
    padding: 70px 15px 65px 15px;
    min-height: 80vh;
}
</style>
<div class="content-page admin-content-page">
    <div class="content chatPage admin-chatPage">
        <!-- Start Content-->
        <div class="container-fluid">
            <h1 class="profile-head">NOTES</h1>
            <div class="row">
                <!-- start chat users-->
                <div class="col-xl-3 col-lg-4">
                    <div class="card chatcard-left">
                        <div class="card-body">

                            <div class="d-flex align-items-start align-items-start mb-3">
                                @if(auth()->user()->profile_picture)
                                <img src="{{ asset('images/users/' . auth()->user()->profile_picture) }}" class="me-2 rounded-circle" height="58" alt="{{ auth()->user()->name }}">
                                @else
                                <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="me-2 rounded-circle" height="58" alt="{{ auth()->user()->name }}">
                                @endif
                                <div class="flex-1">
                                    <h5 class="mt-0 mb-0 font-15">
                                        <a href="contacts-profile.html" class="text-reset">{{auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
                                        <!-- <p class="font-10 mt-1 mb-0">Senior UI/UX Designer</p> -->
                                    </h5>
                                    <!-- <p class="mt-1 mb-0 color-pink font-10">
                                        <small class="mdi mdi-circle  color-pink"></small> Online
                                    </p> -->
                                </div>
                                <!-- <div>
                                    <a href="javascript: void(0);" class="text-reset font-20">
                                        <i class="mdi mdi-cog-outline"></i>
                                    </a>
                                </div> -->
                            </div>
                            <div class="activebox d-flex justify-content-between align-items-center mb-2  ">
                                <p class="text mb-0 px-1">Active Chats</p>
                                <!-- <div class="plus-icon">
                                    <i class="mdi mdi-plus-circle"></i>
                                </div> -->
                            </div>
                            <!-- start search box -->
                            <!-- <form class="search-bar mb-3 chat-leftsearch">
                               <div class="position-relative">
                                     <input type="text" class="form-control form-control-light" placeholder="Search People...">
                                    <span class="mdi mdi-magnify"></span>
                                </div>
                            </form> -->


                            <!-- end search box -->

                            <!-- <h6 class="font-13 text-muted text-uppercase mb-2">Contacts</h6> -->

                            <!-- users -->
                            <div class="row ">
                                <div class="col">
                                    <div data-simplebar="init" style="max-height: 498px">
                                        <div class="simplebar-wrapper" style="margin: 0px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                                                        <div class="simplebar-content" style="padding: 0px;">

                                                            @foreach($rooms as $room)
                                                            <a href="{{ route('chat', $room->id) }}" class="@if($selected_room && $selected_room->id == $room->id) active @endif text-body leftchat-box">
                                                                <div class="d-flex align-items-start p-2 inn-leftchat-box" style="margin-bottom: 20px;">
                                                                    <div class="position-relative">
                                                                        <span class="user-status"></span>
                                                                        @if ($room->Author->id == auth()->user()->id)
                                                                        @if ($room->Participant->profile_picture)
                                                                        <img src="{{ asset('images/users/' . $room->Participant->profile_picture) }}" class="me-2 rounded-circle" height="42" alt="{{ $room->Participant->first_name }} {{ $room->Participant->last_name }}">
                                                                        @else
                                                                        <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="me-2 rounded-circle" height="42" alt="static">
                                                                        @endif
                                                                        @elseif ($room->Participant->id == auth()->user()->id)
                                                                        @if ($room->Author->profile_picture)
                                                                        <img src="{{ asset('images/users/' . $room->Author->profile_picture) }}" class="me-2 rounded-circle" height="42" alt="{{ $room->Author->first_name }} {{ $room->Author->last_name }}">
                                                                        @else
                                                                        <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="me-2 rounded-circle" height="42" alt="static">
                                                                        @endif
                                                                        @endif
                                                                    </div>
                                                                    <div class="flex-1">
                                                                        <h5 class="mt-0 mb-0 font-13">
                                                                            @if($room->Author->id == auth()->user()->id)
                                                                            {{ $room->Participant->first_name ." ". $room->Participant->last_name }}
                                                                            @else
                                                                            {{ $room->Author->first_name ." ". $room->Author->last_name }}
                                                                            @endif
                                                                        </h5>
                                                                        <!-- <p class="mt-1 mb-0 text-muted font-10">
                                                                            <span class="w-25 float-end text-end"><span class="badge badge-soft-danger">3</span></span>
                                                                        </p> -->
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            @endforeach


                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder" style="width: auto; height: 615px;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                            <div class="simplebar-scrollbar" style="height: 403px; transform: translate3d(0px, 77px, 0px); display: block;"></div>
                                        </div>
                                    </div> <!-- end slimscroll-->
                                </div> <!-- End col -->
                            </div>
                            <!-- end users -->
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
                <!-- end chat users-->

                <!-- chat area -->
                @if($selected_room)
                <div class="col-xl-8 col-lg-8 mainChatRoom">
                    <div class="card-header">
                        <div class="chatHeader">
                            <span class="chatUserThumb"><img src="" alt=""></span>
                            <span class="chatRoomUserInfo">
                                <span class="chatRoomUser">
                                    @if($selected_room->Author->id == auth()->user()->id)
                                    {{ $selected_room->Participant->first_name ." ". $selected_room->Participant->last_name }}
                                    @else
                                    {{ $selected_room->Author->first_name ." ". $selected_room->Author->last_name }}
                                    @endif
                                    <strong>Welcome to Calliey</strong>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chatRoomBox" style="max-height: 540px">
                            <ul class="conversation-list chat-app-conversation heycalla-rightchat" id="conversation-list" data-simplebar="init" style="height: 507px; overflow-y: auto;">
                            </ul>
                            <div class="row chat-formsubmit-row">
                                <div class="col">
                                    <div class="mt-2 chat-formsubmit">
                                        <form class="needs-validation" novalidate="" name="chat-form" id="chat-form">
                                            <div class="row align-items-center">
                                                <div class="col mb-2 mb-sm-0">
                                                    <input type="text" class="form-control border-0 chat-msg" placeholder="Enter your text" required="">
                                                    <div class="invalid-feedback mt-2">
                                                        Please enter your messsage
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="btn-group chat-btns">
                                                        <!-- <a href="#" class="btn"> <i class="far fa-smile"></i></a>
                                                        <a href="#" class="btn"><i class="fe-paperclip"></i></a> -->
                                                        <div class="d-grid">
                                                            <button class="btn chat-send"><i class="fe-send"></i></button>
                                                        </div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </form>
                                    </div>
                                </div> <!-- end col-->
                            </div>

                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <!-- end chat area-->

    </div>
    <!-- end row -->

</div> <!-- container -->

</div> <!-- content -->

</div>

<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-firestore.js"></script>

<script>
    const sender_id = '{{ $sender_id }}'
    const reciever_id = '{{ $reciever_id }}'

    var docId = undefined
    var participants = <?php echo json_encode($participants); ?>;
    const attachment = '{{ $attachment }}'

    const firebaseConfig = {
    apiKey: "AIzaSyAAUjqcs6wU2V4-pp4ckUqOz2IMIMYX3FE",
    authDomain: "rmrl-d4e3d.firebaseapp.com",
    databaseURL: "https://rmrl-d4e3d-default-rtdb.firebaseio.com",
    projectId: "rmrl-d4e3d",
    storageBucket: "rmrl-d4e3d.appspot.com",
    messagingSenderId: "439597883487",
    appId: "1:439597883487:web:e3e559a814a1dbadb07bea",
    measurementId: "G-J9VYLRZQBV"
  };
    firebase.initializeApp(firebaseConfig);
    var db = firebase.firestore();

    const getDocId = async (sender_id, reciever_id) => {
        let arr = [];

        let chatsQuery = await db.collection("chats").where("reciverId", "==", reciever_id).where("senderId", "==", sender_id)
        let res = await chatsQuery.get()

        if (res?.docs?.length === 0) {
            let chatsQuery = await db.collection("chats").where("reciverId", "==", sender_id).where("senderId", "==", reciever_id)
            let res = await chatsQuery.get()

            if (res?.docs?.length === 0) {
                // create document
                const document = await db.collection("chats").add({
                    lastMsg: '',
                    updatedAt: firebase.firestore.FieldValue.serverTimestamp(),
                    unReadCount: firebase.firestore.FieldValue.increment(0),
                    isRead: false,
                    senderId: sender_id,
                    reciverId: reciever_id,
                    isBlocked: false,
                    blockedBy: []
                });

                return [document.id];
            }

            res.forEach(async doc => arr.push(doc.id));
            return arr;
        }

        res.forEach(async doc => arr.push(doc.id));


        return arr;
    }

    // const getMsgs = async (docId) => {
    //     try {
    //         if (!docId) return []

    //         let arr = []
    //         let res = await db.collection("chats").doc(docId).collection('msg')
    //             .orderBy('createdAt', 'desc')
    //             .limit(10).get()

    //         res.forEach(eachMessage => {
    //             arr.push(eachMessage.data())
    //         })

    //         return arr.reverse()

    //     } catch (error) {
    //         console.log("error", error)
    //         return [];
    //     }
    // }

    const getRealTimeMessages = async (docId) => {
        try {
            db.collection('chats').doc(docId).collection('msg')
                .orderBy('createdAt', 'asc')
                .limit(11)
                .onSnapshot((res) => {
                    let html = "";

                    res.forEach(function(doc) {
                        let data = doc.data();
                        let sender_user = participants.find(e => e.id == data.senderId);

                        // Extracting time from createdAt field
                        const timestamp = data.createdAt.toDate(); // Convert Firestore Timestamp to JavaScript Date object
                        const options = {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        }; // Specify options to exclude AM/PM
                        const messageTime = timestamp.toLocaleTimeString([], options);

                        // Construct the HTML with the message and image URL
                        html += `
                        <li class="clearfix ${sender_id == data.senderId ? 'odd' : ''}">
                            <div class="chat-avatar">
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                <p style="color:white">${(data.type == 'image' ? "<a href='"+ data.text +"' target='_blank'>Attachment</a>" : data.text)}</p>
                                    ${data.type == 'image' ? `<img src="${data.text}" alt="Attachment">` : ''}
                                </div>
                                <p>${messageTime}</p>
                            </div>
                        </li>
                    `;
                    });

                    $('.conversation-list').html(`<ul style="list-style-type: none;">${html}</ul>`);

                    var objDiv = document.getElementById("conversation-list");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }, function(err) {
                    console.log("Error: ", err);
                });
        } catch (error) {
            console.log("Error: ", error);
        }
    };



    const handleSent = async (docId, msg, image = false, sender_id, reciever_id) => {
        try {
            const payload = {
                createdAt: firebase.firestore.FieldValue.serverTimestamp(),
                senderId: sender_id,
                text: msg,
                reciverId: reciever_id,
                type: image ? 'image' : 'text'
            }

            let res = await db.collection("chats").doc(docId).set({
                lastMsg: msg || 'attachment',
                updatedAt: firebase.firestore.FieldValue.serverTimestamp(),
                unReadCount: firebase.firestore.FieldValue.increment(1),
                isRead: false,
                senderId: sender_id,
                reciverId: reciever_id
            }, {
                merge: true
            });

            res = db.collection('chats').doc(docId).collection('msg').add(payload)

            return res

        } catch (error) {
            console.log("error", error)
            return false
        }
    }

    const chatInit = async () => {
        if (sender_id == 0 || reciever_id == 0) return

        const docIds = await getDocId(sender_id, reciever_id)
        docId = docIds.length > 0 ? docIds[0] : null

        await getRealTimeMessages(docId)

        $('.mainChatRoom').show();

        //if redirecting from quote screen with attachment
        if (attachment) {
            await handleSent(docId, attachment, true, sender_id, reciever_id)
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
        }
    }

    $(document).ready(function() {
        chatInit()
    });

    const sendMessage = async () => {
        let msg = $('.chat-msg').val();
        if (!msg) return console.log('Invalid msg')

        if (!docId) return console.log('Invalid docId')

        $('.chat-msg').val('');

        await handleSent(docId, msg, false, sender_id, reciever_id)
    }

    document.getElementsByClassName("chat-msg")[0].addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            sendMessage();
        }
    });

    $(document).on("click", ".chat-send", async function() {
        await sendMessage();
    });

    function onAttachmentChange(elm) {
        let value = elm.files[0];

        let url = "{{ route('upload.attachment') }}"
        var form_data = new FormData();
        form_data.append('media', value);

        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: async function(data) {
                if (data?.data?.media_url) {
                    await handleSent(docId, data?.data?.media_url, true, sender_id, reciever_id)
                }
            },
            error: function(data) {
                console.log('Image uploaded error');
            }
        });
    }


</script>


@endsection