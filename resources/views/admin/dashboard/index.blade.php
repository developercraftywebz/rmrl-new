@extends('layouts.dashboard')

@section('content')

    <style>
        .list-a.post-toggler-ul.d-block li {
            cursor: pointer;
        }
    </style>

    <section class="post-box-section">
        <div class="container w-100">
            <!-- All the post type forms -->
            <div class="post_types">
                <div id="textPost">
                    <form action="{{ route('store-blog') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="post-text-area">
                                <textarea name="" id="" placeholder="Say what is on your mind..." class="post-inp-a"></textarea>
                            </div>
                            @error('blog_post')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary d-none" id="submitButton">Post</button>
                    </form>
                </div>

                <div id="mediaInputBox" class="d-none p-4">
                    <form method="POST" action="{{ route('dashboard.storeMedia') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3">
                            <label for="files" class="form-label">Upload Media</label>
                            <input type="file" class="form-control" id="files" name="files[]" required
                                accept="image/*,video/*" multiple>
                            @error('files')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->album_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>

                <div id="groupForm" class="d-none p-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#groupFormModal">
                        Create group
                    </button>
                    <div class="modal fade" id="groupFormModal" tabindex="-1" aria-labelledby="groupFormModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="groupFormModalLabel">Create Group</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('dashboard.createGroup') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="group_name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="group_name" id="group_name"
                                                placeholder="Enter your group's name..." required>
                                            @error('group_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="group_description" class="form-label">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea type="text" class="form-control" name="group_description" id="group_description"
                                                placeholder="Enter your group's description..." required></textarea>
                                            @error('group_description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="privacy_type">Privacy</label>
                                            <select class="form-select" id="privacy_type" name="privacy_type">
                                                <option value="Open">Open</option>
                                                <option value="Private">Private</option>
                                                <option value="Secret">Secret</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Create Group</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="categoryForm" class="d-none p-4">
                    <form method="POST" action="{{ route('home') }}">
                        @csrf
                        <div>
                            <label for="category" class="form-label">Create an Album</label>
                            <input type="text" class="form-control" name="name" id="category">
                        </div>
                        <div class="my-2">
                            <input type="submit" class="btn btn-primary" value="Create Album">
                        </div>
                    </form>
                </div>

                <div id="pollForm" class="d-none p-4">
                    <form method="POST" action="{{ route('store-poll') }}" id="actualPollForm">
                        @csrf
                        <div class="my-1">
                            <input class="form-control poll-option option_1" id="option_1" type="text"
                                name="options[]" placeholder="Option 1">
                            @error('options.0')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="my-1">
                            <input class="form-control poll-option option_2" id="option_2" type="text"
                                name="options[]" placeholder="Option 2">
                            @error('options.1')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="optionsContainer"></div>
                        <a href="#" class="btn btn-success" id="add_more_btn">Add more options</a>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="allow_multiple" name="allow_multiple">
                            <label class="form-check-label" for="allow_multiple">Allow multiple options to be
                                selected</label>
                            @error('allow_multiple')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="my-1">
                            <textarea class="form-control question" id="question" name="question" rows="4"
                                placeholder="Say something about this poll...">{{ old('question') }}</textarea>
                            @error('question')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-none poll_post_btn" id="poll_post_btn">
                            <input type="submit" class="btn btn-primary" value="Post">
                        </div>
                    </form>
                </div>

                <div id="fileForm" class="d-none p-4">
                    <form action="{{ route('store-file') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file" accept="application/pdf">
                            @error('file')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="file_details" cols="30" rows="4" placeholder="File details">{{ old('file_details') }}</textarea>
                            @error('file_details')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>

                <div>
                    <div id="gif" class="my-4 d-none p-4">
                        <div id="gif-slider">
                            <div id="gif-container" class="gif-container">
                                @foreach ($gifs as $gif)
                                    <div class="gif-item">
                                        <img src="{{ $gif['images']['original']['url'] }}" alt="GIF">
                                    </div>
                                @endforeach
                            </div>
                            <button id="slide-left" class="slider-button">&lt;</button>
                            <button id="slide-right" class="slider-button">&gt;</button>
                        </div>
                    </div>

                    <form id="gif-selection-form" action="{{ route('store-gif') }}" method="POST"
                        style="display: none;">
                        @csrf
                        <div class="selected-gif-preview">
                            <img id="selected-gif-preview" src="" alt="Selected GIF">
                            <button type="button" id="remove-selected-gif" class="btn btn-danger">Remove
                                GIF</button>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="text" name="url" id="selected-gif"
                                placeholder="GIF URL" hidden>
                            @error('url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit GIF</button>
                    </form>
                </div>
            </div>

            <!-- Custom dropdown for post types -->
            <div class="post-box-footer">
                <div class="pbox-footer-left">
                    <div>
                        <ul class="list-a post-toggler-ul" onclick="toggleOptions()" style="cursor: pointer;">
                            <li><a href="#!" onclick="selectOption('text_post')"><i class="ri-pencil-fill"></i></a>
                            </li>
                            <li><i class="ri-camera-fill"></i></li>
                            <li><i class="ri-video-fill"></i></li>
                            <li><i class="ri-list-check"></i>
                            </li>
                            <li><i class="ri-file-fill"></i></li>
                            <li><i class="ri-file-gif-fill"></i>
                            </li>
                        </ul>
                        <div id="options-container" style="display: none;">
                            <ul class="list-a post-toggler-ul d-block">
                                <li onclick="selectOption('text_post')">Text Post</li>
                                <li onclick="selectOption('media')">Media</li>
                                <li onclick="selectOption('group')">Group</li>
                                <li onclick="selectOption('category')">Category</li>
                                <li onclick="selectOption('poll')">Poll</li>
                                <li onclick="selectOption('file')">File</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Privacy section -->
                    <div class="privacy-toggler">
                        <div class="privacy-selected">
                            <a href="#!"><i class="ri-group-fill"></i> Public</a>
                        </div>
                    </div>
                    <div class="pin-togglers">
                        <a href="#!"><i class="ri-pushpin-2-fill"></i></a>
                    </div>
                    <div class="shedule-togglers">
                        <a href="#!"><i class="ri-time-line"></i></a>
                    </div>
                    <div class="to-post-togglers">
                        <a href="#!"><i class="ri-team-line"></i></a>
                    </div>
                    <div class="mood-toggler-a">
                        <a href="#!"><i class="ri-user-smile-line"></i></a>
                    </div>
                </div>
            </div>

            <!-- Showing all the data -->
            <div class="row">
                <div class="col-12 p-4">
                    @if (!is_null($textPosts) && count($textPosts) > 0)
                        <div class="section">
                            <h2>Text Posts</h2>
                            @foreach ($textPosts as $textPost)
                                <div class="post card p-3">
                                    <p>{{ $textPost->blog_post }}</p>

                                    <form
                                        action="{{ route('comments.add', ['commentableType' => 'post', 'commentableId' => $textPost->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="form-group my-2">
                                            <textarea name="content" rows="3" placeholder="Add a text comment" class="form-control"></textarea>
                                        </div>
                                        <input type="hidden" name="type" value="text" class="form-control">
                                        <button type="submit" class="btn btn-primary my-2">Submit</button>
                                    </form>

                                    <div class="card my-4">
                                        @foreach ($textPost->comments as $comment)
                                            <div class="card-body comment">
                                                <p>{{ $comment->content }}</p>
                                                @if (!empty($comment->content))
                                                    <button type="button" class="btn btn-success"
                                                        onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
                                                    <div id="replyForm{{ $comment->id }}" style="display: none;"
                                                        class="my-4">
                                                        <form
                                                            action="{{ route('comments.reply', ['commentId' => $comment->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <textarea name="content" rows="3" placeholder="Write a reply" class="form-control"></textarea>
                                                            </div>
                                                            <input type="hidden" name="type" value="reply"
                                                                class="form-control">
                                                            <button type="submit" class="btn btn-primary mt-2">Submit
                                                                Reply</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                @foreach ($comment->replies as $reply)
                                                    <div class="card-body reply">
                                                        <p>{{ $reply->content }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-12 p-4">
                    @foreach ($categoryMedia as $category)
                        @if (count($category->media) > 0)
                            <div class="card p-3">
                                <h5 class="card-title">
                                    {{ $category->album_name }}
                                </h5>
                                @foreach ($category->media as $media)
                                    @if ($media->file_type === 'Image')
                                        <img src="{{ $media->file_path }}" alt="Image" width="350"
                                            height="300">
                                    @elseif ($media->file_type === 'Video')
                                        <video src="{{ $media->file_path }}" controls></video>
                                    @endif

                                    <form
                                        action="{{ route('comments.add', ['commentableType' => 'media', 'commentableId' => $media->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="form-group my-2">
                                            <textarea name="content" rows="3" placeholder="Add a comment for this media" class="form-control"></textarea>
                                        </div>
                                        <input type="hidden" name="type" value="media" class="form-control">
                                        <button type="submit" class="btn btn-primary my-2">Submit</button>
                                    </form>

                                    <div class="card my-4">
                                        @foreach ($media->comments as $comment)
                                            <div class="card-body comment">
                                                <p>{{ $comment->content }}</p>
                                                @if (!empty($comment->content))
                                                    <button type="button" class="btn btn-success"
                                                        onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
                                                    <div id="replyForm{{ $comment->id }}" style="display: none;">
                                                        <form
                                                            action="{{ route('comments.reply', ['commentId' => $comment->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="form-group my-2">
                                                                <textarea name="content" rows="3" placeholder="Write a reply" class="form-control"></textarea>
                                                            </div>
                                                            <input type="hidden" name="type" value="reply"
                                                                class="form-control">
                                                            <button type="submit" class="btn btn-primary">Submit
                                                                Reply</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                @foreach ($comment->replies as $reply)
                                                    <div class="card-body comment">
                                                        <p>{{ $reply->content }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                @if (count($polls) > 0)
                    <div class="col-12 p-4">
                        <h2>Polls</h2>
                        @foreach ($polls as $poll)
                            <div class="poll card p-3">
                                <p class="display-5">{{ $poll->question }}</p>
                                @php
                                    $userHasSubmitted = Auth::check() && Auth::user()->pollSubmissions->contains('poll_id', $poll->id);
                                @endphp
                                @if ($userHasSubmitted)
                                    <p class="fs-3">Your option:
                                        @foreach (Auth::user()->pollSubmissions as $submission)
                                            @if ($submission->poll_id == $poll->id)
                                                {{ implode(', ', json_decode($submission->selected_options)) }}
                                            @endif
                                        @endforeach
                                    </p>
                                @else
                                    <form action="{{ route('polls.submit') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="pollId" value="{{ $poll->id }}">
                                        @if ($poll->allow_multiple === 1)
                                            @foreach ($poll->options as $option)
                                                @if ($option !== null)
                                                    <input type="checkbox" name="poll_option_{{ $poll->id }}[]"
                                                        value="{{ $option }}">
                                                    <label
                                                        for="poll_option_{{ $poll->id }}">{{ $option }}</label><br>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($poll->options as $option)
                                                @if ($option !== null)
                                                    <input type="radio" name="poll_option_{{ $poll->id }}"
                                                        value="{{ $option }}">
                                                    <label
                                                        for="poll_option_{{ $poll->id }}">{{ $option }}</label><br>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                @endif

                                <form
                                    action="{{ route('comments.add', ['commentableType' => 'poll', 'commentableId' => $poll->id]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group my-2">
                                        <textarea name="content" rows="3" placeholder="Add a comment for this poll" class="form-control"></textarea>
                                    </div>
                                    <input type="hidden" name="type" value="poll" class="form-control">
                                    <button type="submit" class="btn btn-primary my-2">Submit</button>
                                </form>

                                <div class="card my-4">
                                    @foreach ($poll->comments as $comment)
                                        <div class="card-body comment">
                                            <p>{{ $comment->content }}</p>
                                            @if (!empty($comment->content))
                                                <button type="button" class="btn btn-success"
                                                    onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
                                                <div id="replyForm{{ $comment->id }}" style="display: none;">
                                                    <form
                                                        action="{{ route('comments.reply', ['commentId' => $comment->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <textarea name="content" rows="3" placeholder="Write a reply" class="form-control"></textarea>
                                                        </div>
                                                        <input type="hidden" name="type" value="reply"
                                                            class="form-control">
                                                        <button type="submit" class="btn btn-primary">Submit
                                                            Reply</button>
                                                    </form>
                                                </div>
                                            @endif
                                            @foreach ($comment->replies as $reply)
                                                <div class="card-body reply">
                                                    <p>{{ $reply->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="col-12 p-4">
                    <div class="section">
                        <h2>Files</h2>
                        <div class="card p-3">
                            @foreach ($files as $file)
                                <div class="file">
                                    <p class="display-5">{{ $file->file_details }}</p>
                                    <a href="{{ $file->file }}" target="_blank">{{ $file->file_name }}</a>
                                </div>

                                <form
                                    action="{{ route('comments.add', ['commentableType' => 'file', 'commentableId' => $file->id]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="content" rows="3" placeholder="Add a comment for this file" class="form-control"></textarea>
                                    </div>
                                    <input type="hidden" name="type" value="file" class="form-control">
                                    <button type="submit" class="btn btn-primary my-2">Submit</button>
                                </form>

                                <div class="card my-4">
                                    @foreach ($file->comments as $comment)
                                        <div class="card-body comment">
                                            <p>{{ $comment->content }}</p>
                                            @if (!empty($comment->content))
                                                <button type="button" class="btn btn-success"
                                                    onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
                                                <div id="replyForm{{ $comment->id }}" style="display: none;">
                                                    <form
                                                        action="{{ route('comments.reply', ['commentId' => $comment->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="form-group my-2">
                                                            <textarea name="content" rows="3" placeholder="Write a reply" class="form-control"></textarea>
                                                        </div>
                                                        <input type="hidden" name="type" value="reply"
                                                            class="form-control">
                                                        <button type="submit" class="btn btn-primary">Submit
                                                            Reply</button>
                                                    </form>
                                                </div>
                                            @endif
                                            @foreach ($comment->replies as $reply)
                                                <div class="card-body reply">
                                                    <p>{{ $reply->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 p-4">
                    @if ($gif)
                        <div class="section">
                            <h2>GIFs</h2>
                            <div class="card p-3">
                                <h5 class="card-title">
                                    {{ Auth::user()->role_id ? \App\Enums\UserTypes::LIST[Auth::user()->role_id] . ' shared a GIF' : '' }}
                                </h5>
                                @foreach ($gif as $gif)
                                    <img src="{{ $gif->url }}" alt="GIF" class="img-fluid my-2"
                                        width="150">

                                    <form
                                        action="{{ route('comments.add', ['commentableType' => 'gif', 'commentableId' => $gif->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="form-group my-2">
                                            <textarea name="content" rows="3" placeholder="Add a comment for this GIF" class="form-control"></textarea>
                                        </div>
                                        <input type="hidden" name="type" value="gif" class="form-control">
                                        <button type="submit" class="btn btn-primary my-2">Submit</button>
                                    </form>

                                    <div class="card my-4">
                                        @foreach ($gif->comments as $comment)
                                            <div class="card-body comment">
                                                <p>{{ $comment->content }}</p>
                                                @if (!empty($comment->content))
                                                    <button type="button" class="btn btn-success"
                                                        onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
                                                    <div id="replyForm{{ $comment->id }}" style="display: none;">
                                                        <form
                                                            action="{{ route('comments.reply', ['commentId' => $comment->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <textarea name="content" rows="3" placeholder="Write a reply" class="form-control"></textarea>
                                                            </div>
                                                            <input type="hidden" name="type" value="reply"
                                                                class="form-control">
                                                            <button type="submit" class="btn btn-primary">Submit
                                                                Reply</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                @foreach ($comment->replies as $reply)
                                                    <div class="card-body reply">
                                                        <p>{{ $reply->content }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p>No GIFs available at the moment.</p>
                    @endif
                </div>
            </div>

        </div>
    </section>

    <script>
        function toggleOptions() {
            var optionsContainer = document.getElementById("options-container");
            if (optionsContainer.style.display === "none") {
                optionsContainer.style.display = "block";
            } else {
                optionsContainer.style.display = "none";
            }
        }
    </script>

    <script>
        function toggleOptions() {
            var optionsContainer = document.getElementById("options-container");
            if (optionsContainer.style.display === "none") {
                optionsContainer.style.display = "block";
            } else {
                optionsContainer.style.display = "none";
            }
        }

        function selectOption(option) {
            console.log("Selected Option:", option);

            // Hide all forms by default
            var textPost = document.getElementById("textPost");
            var media = document.getElementById("mediaInputBox");
            var group = document.getElementById("groupForm");
            var category = document.getElementById("categoryForm");
            var poll = document.getElementById("pollForm");
            var file = document.getElementById("fileForm");
            var gif = document.getElementById("gif");

            textPost.classList.add("d-none");
            media.classList.add("d-none");
            group.classList.add("d-none");
            category.classList.add("d-none");
            poll.classList.add("d-none");
            file.classList.add("d-none");
            gif.classList.add("d-none");

            // Show the selected form
            if (option === "text_post") {
                textPost.classList.remove("d-none");
            } else if (option === "media") {
                media.classList.remove("d-none");
            } else if (option === "group") {
                group.classList.remove("d-none");
            } else if (option === "category") {
                category.classList.remove("d-none");
            } else if (option === "poll") {
                poll.classList.remove("d-none");
            } else if (option === "file") {
                file.classList.remove("d-none");
            } else if (option === "gif") {
                gif.classList.remove("d-none");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const gifSlider = document.getElementById('gif-slider');
            const slideLeftButton = document.getElementById('slide-left');
            const slideRightButton = document.getElementById('slide-right');
            let offset = 0;
            let clearGifs = false;
            const gifContainer = document.getElementById('gif-container');
            const gifItemWidth = 210; // Adjust this value based on your GIF item width

            slideLeftButton.addEventListener('click', function() {
                offset -= gifItemWidth; // Adjust the step size based on your GIF item width
                clearGifs = true;
                updateGIFContainerTransform();
            });

            slideRightButton.addEventListener('click', function() {
                offset += gifItemWidth; // Adjust the step size based on your GIF item width
                clearGifs = true;
                updateGIFContainerTransform();
            });

            function updateGIFContainerTransform() {
                gifContainer.style.transform = `translateX(${offset}px)`;
                if (clearGifs) {
                    gifContainer.innerHTML = '';
                    clearGifs = false;
                    loadGIFs(offset);
                }
            }

            function loadGIFs(offset) {
                const url =
                    `https://api.giphy.com/v1/gifs/trending?api_key=mH0QrKDXHW6puYlwdoWrem8oWuNhqcJn&limit=5&offset=${offset}&rating=g&bundle=messaging_non_clips`;

                fetch(url)
                    .then((response) => response.json())
                    .then((data) => {
                        data.data.forEach((gif) => {
                            const gifItem = document.createElement('div');
                            gifItem.classList.add('gif-item');
                            gifItem.style.width = '-webkit-fill-available'; // Set the width style
                            const img = document.createElement('img');
                            img.src = gif.images.original.url;
                            img.alt = 'GIF';
                            gifItem.appendChild(img);
                            gifContainer.appendChild(gifItem);
                        });
                    })
                    .catch((error) => {
                        console.error('Failed to load GIFs:', error);
                    });
            }

            // Initial load of GIFs
            loadGIFs(offset);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const gifContainer = document.getElementById('gif-container');
            const gifSelectionForm = document.getElementById('gif-selection-form');
            const selectedGifInput = document.getElementById('selected-gif');
            const selectedGifPreview = document.getElementById('selected-gif-preview');
            const removeSelectedGifButton = document.getElementById('remove-selected-gif');

            // Event listener for clicking on a GIF
            gifContainer.addEventListener('click', function(event) {
                const clickedGif = event.target;

                // Check if the clicked element is an <img> tag inside a .gif-item
                if (clickedGif.tagName === 'IMG' && clickedGif.parentElement.classList.contains(
                        'gif-item')) {
                    // Get the URL of the clicked GIF
                    const gifUrl = clickedGif.src;

                    // Set the selected GIF URL in the hidden input field
                    selectedGifInput.value = gifUrl;

                    // Display the form with the selected GIF
                    gifSelectionForm.style.display = 'block';

                    // Set the preview image source
                    selectedGifPreview.src = gifUrl;
                }
            });

            // Event listener for removing the selected GIF
            removeSelectedGifButton.addEventListener('click', function() {
                // Clear the selected GIF URL in the hidden input field
                selectedGifInput.value = '';

                // Hide the form
                gifSelectionForm.style.display = 'none';

                // Clear the preview image
                selectedGifPreview.src = '';
            });
        });

        function toggleButton() {
            var textArea = document.getElementById("textArea");
            var submitButton = document.getElementById("submitButton");

            if (textArea.value.trim() === "") {
                submitButton.classList.add("d-none");
            } else {
                submitButton.classList.remove("d-none");
            }
        }
    </script>

    <script>
        let optionCount = 2;
        let isAddingOption = false;
        const optionsContainer = document.getElementById('optionsContainer');

        function toggleRemoveButtons() {
            const options = optionsContainer.querySelectorAll('.poll-option');
            const removeButtons = optionsContainer.querySelectorAll('.remove_option');
            const defaultRemoveButtons = document.querySelectorAll('.my-1 .remove_option');
            if (optionCount >= 2) {
                removeButtons.forEach(button => button.removeAttribute('disabled'));
                defaultRemoveButtons.forEach(button => button.removeAttribute('disabled'));
            } else {
                removeButtons.forEach(button => button.setAttribute('disabled', 'disabled'));
                defaultRemoveButtons.forEach(button => button.setAttribute('disabled', 'disabled'));
            }
        }
        toggleRemoveButtons();

        document.getElementById('add_more_btn').addEventListener('click', function(event) {
            event.preventDefault();
            optionCount++;
            const newOptionInput = document.createElement('div');
            newOptionInput.innerHTML = `
    <div class="my-1">
        <input class="form-control poll-option option_${optionCount}" id="option_${optionCount}" type="text"
            name="options[]" placeholder="Option ${optionCount}" required>
        <button type="button" class="btn btn-danger remove_option">Remove</button>
    </div>
    `;

            optionsContainer.appendChild(newOptionInput);
            const removeButton = newOptionInput.querySelector('.remove_option');
            removeButton.addEventListener('click', function() {
                optionsContainer.removeChild(newOptionInput);
                optionCount--;
                toggleRemoveButtons();
                togglePostBtnVisibility(); // Add this line to update button visibility
            });

            toggleRemoveButtons();
            togglePostBtnVisibility(); // Add this line to update button visibility
        });

        const questionTextarea = document.getElementById('question');
        const pollPostBtn = document.getElementById('poll_post_btn');

        function togglePostBtnVisibility() {
            const firstOption = document.getElementById('option_1');
            const secondOption = document.getElementById('option_2');

            // Check if there are at least two options, either the default or dynamic ones
            const options = optionsContainer.querySelectorAll('.poll-option');

            if (
                ((firstOption.value.trim() !== '' || secondOption.value.trim() !== '') &&
                    // At least one of the default options is filled
                    questionTextarea.value.trim() !== '') || (
                    (options.length >= 2 && questionTextarea.value.trim() !==
                        '') // At least two options (default or dynamic) and question filled
                )
            ) {
                pollPostBtn.classList.remove('d-none');
            } else {
                pollPostBtn.classList.add('d-none');
            }

            // Check if the total number of filled options is less than 2, then hide the Post button
            const filledOptions = [...options, firstOption, secondOption].filter(option => option.value.trim() !== '');
            if (filledOptions.length < 2) {
                pollPostBtn.classList.add('d-none');
            }
        }

        const firstOption = document.getElementById('option_1');
        const secondOption = document.getElementById('option_2');

        firstOption.addEventListener('input', function() {
            togglePostBtnVisibility();
        });
        secondOption.addEventListener('input', function() {
            togglePostBtnVisibility();
        });
        questionTextarea.addEventListener('input', function() {
            togglePostBtnVisibility();
        });
        optionsContainer.addEventListener('focusin', function() {
            isAddingOption = true;
        });
        optionsContainer.addEventListener('focusout', function() {
            isAddingOption = false;
        });

        document.getElementById('actualPollForm').addEventListener('submit', function(event) {
            if (isAddingOption) {
                event.preventDefault();
                alert('Please finish adding options before submitting.');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const allowMultipleCheckbox = document.getElementById('allow_multiple');

            // Add an event listener to the checkbox
            allowMultipleCheckbox.addEventListener('change', function() {
                // Set the value to "1" if the checkbox is checked, or empty string otherwise
                this.value = this.checked ? '1' : '';
            });
        });
    </script>

    <script>
        function toggleReplyForm(commentId) {
            var x = document.getElementById("replyForm" + commentId);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
@endsection
