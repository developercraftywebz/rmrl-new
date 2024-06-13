@extends('layouts.group_dashboard')

@section('content')
<style>
    .repliesAvatar {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: lightgray;
        border: 2px solid transparent;
    }

    .commentAvatar {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: lightgray;
        border: 2px solid transparent;
    }

    .comment_delete_btn {
        padding: 10px !important;
        font-size: 14px;
        font-family: 'Poppins Regular';
        color: #494954;
        background-color: white;
        border: none;
        text-align: left;
    }

    .ps-dropdown__menu .ps-js-dropdown-menu .dropdown-menu .show {
        position: absolute;
        inset: 0px 0px auto auto;
        margin: 0px;
        width: 200px;
        transform: translate3d(0px, 38.4px, 0px);
    }

    .editTextarea {
        height: 42px;
        width: 90%;
        vertical-align: middle;
        padding: 10px;
        background-color: #efefef;
        border: 0;
        border-radius: 10px;
    }

    #lightboxImage {
        width: 350px;
        height: 350px;
    }
</style>


<div class="container border-0 mb-2">
    @if (session('flash_success'))
    <div class="alert alert-success" role="alert">
        {{ session('flash_success') }}
    </div>
    @elseif(session('flash_error'))
    <div class="alert alert-danger" role="alert">
        {{ session('flash_error') }}
    </div>
    @endif
</div>


@if (auth()->user()->role_id != 1)
<section class="post-box-section">
    <div class="container">
        <div id="postbox-status" class="postbox_content postbox-content">
            <!-- All post types -->
            <div class="postbox_views postbox-tabs">
                <div class="post_types">
                    <div id="textPost">
                        <form action="{{ route('dashboard.group.post', ['id' => $group->id]) }}" method="POST" id="blogForm">
                            @csrf
                            <div class="mb-3">
                                <div class="post-text-area border border-1">
                                    <textarea name="text_post" id="text_post" placeholder="Say what is on your mind..." class="post-inp-a" onkeyup="checkTextArea()"></textarea>
                                </div>
                                <input type="hidden" name="type" value="text post">
                                @error('text_post')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>

                    <div id="mediaInputBox" class="d-none">
                        <div class="postbox_view post_media_box" data-tab-id="photos" onclick="initiateFileInput()">
                            <div class="postbox__photos postbox-input post-inputbox">
                                <form method="POST" action="{{ route('dashboard.group.post', ['id' => $group->id]) }}" enctype="multipart/form-data" id="mediaForm">
                                    @csrf
                                    <div class="postbox_photos-inner">
                                        <div id="upload-container" class="postbox_photos-upload">
                                            <div class="postbox_photos-info postbox-photo-upload" id="upload-info">
                                                <div class="postbox_photos-message">
                                                    <i class="ri-gallery-line"></i> Click here to start
                                                    uploading photos
                                                </div>
                                                <div class="postbox_photos-limits">Max photo dimensions:
                                                    4000 x
                                                    3000px | Max file size: 20MB</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="postbox_photos-preview postbox-preview" id="preview-container">
                                        <div class="postbox_photos-list-wrapper">
                                            <input type="file" class="form-control d-none" id="files" name="media_url[]" required accept="image/*,video/*" multiple>
                                            @error('files')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="postbox_photos-list pstbx-photos ui-sortable pstbx-initialized" id="photos-list">
                                                <div class="postbox_photos-item postbox_photos-item--add pstbx-upload">
                                                    <i class="gcir gci-plus-square"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="postbox_media-separator pstbx-video-separator">
                                            <span>or </span>
                                        </div>
                                        <div class="postbox_media-upload pstbx-video-upload">
                                            <div class="postbox_media-action pstbx-btn">
                                                <i class="ri-chat-upload-line"></i>
                                                <strong>Upload</strong>
                                                <span>Max file size: 20MB</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="categoryForm" class="d-none p-4">
                        <form method="POST" action="{{ route('dashboard.storeCategory') }}" id="creatCategoryForm">
                            @csrf
                            <input type="hidden" name="type" value="category">
                            <div>
                                <label for="category" class="form-label">Create an Album</label>
                                <input type="text" class="form-control" name="album_name" id="category">
                            </div>
                        </form>
                    </div>

                    <div id="fileForm" class="d-none p-4">
                        <form action="{{ route('dashboard.group.post', ['id' => $group->id]) }}" method="POST" enctype="multipart/form-data" id="uploadFileForm">
                            @csrf
                            <input type="hidden" name="type" value="file">
                            <div class="mb-3">
                                <input class="form-control" type="file" name="file_path" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv,text/plain,application/rtf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation">
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
                        </form>
                    </div>

                    <div id="gifForm">
                        <div id="gif" class="my-4 d-none p-4">
                            <div id="gif-slider">
                                <div id="gif-container" class="gif-container"></div>
                                <button id="slide-left" class="slider-button">&lt;</button>
                                <button id="slide-right" class="slider-button">&gt;</button>
                            </div>
                        </div>

                        <form id="gif-selection-form" action="{{ route('dashboard.group.post', ['id' => $group->id]) }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="type" value="gif">
                            <div class="selected-gif-preview">
                                <img id="selected-gif-preview" src="" alt="Selected GIF">
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="gif_url" id="selected-gif" placeholder="GIF URL" hidden>
                                @error('gif_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="button" id="remove-selected-gif" class="ps-btn postbox-submit">Remove
                                GIF</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="post-box-footer">
            <div class="pbox-footer-left">
                <div class="post-type-toggler" data-dropdown="post-dropdown">
                    <a href="#!" class="post_type_menu-item-link menu-item-has-childre" data-dropdown="post-dropdown" onclick="event.preventDefault()">
                        <ul class="list-a post-toggler-ul">
                            <li>
                                <i class="ri-pencil-fill"></i>
                            </li>
                            <li>
                                <i class="ri-camera-fill"></i> <i class="ri-video-fill"></i>
                            </li>
                            <li>
                                <i class="ri-file-fill"></i>
                            </li>
                            <li>
                                <i class="ri-file-gif-fill"></i>
                            </li>
                        </ul>
                    </a>
                    <ul class="list-a dropdown-menu-a shadow" id="post-dropdown">
                        <li onclick="selectOption('text_post')">
                            <a class="dropdown-item clickableElement" href="#!">
                                <i class="ri-pencil-fill"></i>
                                Text post
                            </a>
                        </li>
                        <li onclick="selectOption('media')">
                            <a class="dropdown-item clickableElement" href="#!" data-option-value="photos">
                                <i class="ri-camera-fill"></i>
                                Photo
                                /
                                <i class="ri-video-fill"></i>
                                Video
                            </a>
                        </li>

                        <li onclick="selectOption('file')">
                            <a class="dropdown-item clickableElement" href="#!" data-option-value="videos">
                                <i class="ri-file-fill"></i>
                                File
                            </a>
                        </li>

                        <li onclick="selectOption('gif')">
                            <a class="dropdown-item clickableElement" href="#!" data-option-value="videos">
                                <i class="ri-file-gif-fill"></i>
                                GIF
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pbox-footer-right d-flex justify-content-between">
                <div id="blogFormDiv">
                    <button type="button" class="ps-btn postbox-submit" onclick="submitForm('blogForm')">Post
                        Blog</button>
                </div>
                <div id="mediaFormDiv" class="d-none">
                    <button type="button" class="ps-btn postbox-submit" onclick="submitForm('mediaForm')">Upload
                        Media</button>
                </div>
                <div id="createGroupFormDiv" class="d-none">
                    <button type="button" class="ps-btn postbox-submit" data-bs-toggle="modal" data-bs-target="#groupFormModal">Create Group</button>
                </div>
                <div id="creatCategoryFormDiv" class="d-none">
                    <button type="button" class="ps-btn postbox-submit" onclick="submitForm('creatCategoryForm')">Create Album</button>
                </div>
                <div id="actualPollFormDiv" class="d-none">
                    <button type="button" class="ps-btn postbox-submit" onclick="submitForm('actualPollForm')">Post
                        Poll</button>
                </div>
                <div id="uploadFileFormDiv" class="d-none">
                    <button type="button" class="ps-btn postbox-submit" onclick="submitForm('uploadFileForm')">Upload File</button>
                </div>
                <div id="gifSelectionFormDiv" class="d-none">
                    <button type="button" class="ps-btn postbox-submit" onclick="submitForm('gif-selection-form')">Submit GIF</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if (!$group_posts->isEmpty())
@foreach ($group_posts as $group_post)
<section class="ps-activity_container">
    <div class="container">
        <div id="ps-activitystream" class="ps-posts ps-posts-narrow">
            <div class="ps-post ps-activity ps-activity-post-1 ">
                <div id="all_group_posts">
                    @if ($group_post->type == 'text post')
                    <div>
                        <!-- POST HEADER -->
                        <div class="ps-post__header ps-js-post-header">
                            <a class="ps-avatar ps-avatar--post" href="{{ route('user.about') }}">
                                <div class="d-flex justify-content-center align-items-center text-center" style="width: 61px; height: 61px; border-radius: 50%; background-color: #e9e9e9;">
                                    @if ($group_post->user)
                                    <span style="font-size: 48px; font-weight: bold; color: #c2a006;">
                                        {{ substr($group_post->user->first_name, 0, 1) }}
                                    </span>
                                    @else
                                    <span style="font-size: 16px; font-weight: bold; color: #c2a006;">N/A</span>
                                    @endif
                                </div>
                            </a>
                            <div class="ps-post__meta">
                                <div class="ps-post__info">
                                    <a class="ps-post__date ps-js-timestamp" href="#">
                                        <span class="ps-js-autotime" title="{{ \Carbon\Carbon::parse($group_post->created_at)->format('F d, Y g:i a') }}">
                                            {{ \Carbon\Carbon::parse($group_post->created_at)->diffForHumans() }}
                                        </span>
                                    </a>
                                    <div class="ps-post__privacy ps-dropdown ps-dropdown--privacy ps-js-dropdown ps-privacy--21" title="Post privacy">
                                        <a href="#" class="dropdown-toggle ps-post__privacy-toggle ps-dropdown_toggle ms-3" role="button" id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-team-fill"></i><span class="ms-1">Site
                                                Members</span>
                                        </a>
                                        <div class="ps-dropdown__menu ps-dropdown-menu dropdown-menu posts-dropdown-menu" aria-labelledby="dropdownMenuLink3">
                                            <a href="#"><i class="ri-earth-fill"></i><span class="ms-1">Public</span></a>
                                            <a href="#"><i class="ri-team-fill"></i><span class="ms-1">Site
                                                    Members</span></a>
                                            <a href="#"><i class="ri-user-fill"></i><span class="ms-1">Friends
                                                    Only</span></a>
                                            <a href="#"><i class="ri-lock-fill"></i><span class="ms-1">Only
                                                    Me</span></a>
                                        </div>
                                    </div>
                                    <a class="ps-post__copy" href="#"><span class="ps-tooltip ps-tooltip--permalink" data-tooltip="Click to copy" data-tooltip-initial="Click to copy" data-tooltip-success="Copied."><i class="gcis gci-link"></i></span></a>
                                </div>
                            </div>

                            <div class="ps-post__options ps-js-post-options">
                                <div class="ps-post__options-menu ps-js-dropdown">
                                    <a href="#" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    </a>
                                    <div class="dropdown-menu ps-dropdown__menu ps-js-dropdown-menu" aria-labelledby="dropdownMenuLink4">
                                        <a href="#">
                                            <i class="ri-pencil-line"></i><span class="ms-1">Edit</span>
                                        </a>
                                        <a href="#">
                                            <i class="ri-delete-bin-line"></i><span class="ms-1">Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- POST BODY -->
                        <div class="ps-media ps-media--iframe ps-media-iframe ps-js-video mb-3 custom-post-container">
                            <div class="wp-video mx-3 custom-blog-post">
                                {{ $group_post->text_post }}
                            </div>

                            <!-- like button for posts -->
                            <div class="wp-video mx-3 mt-3">
                                <a href="#" class="group-post-like" data-post-type="text" data-post-id="{{ $group_post->id }}">
                                    @if (auth()->user()->hasLikedGroupPost($group_post))
                                    <i class="ri-thumb-up-fill"></i><span class="ms-1 custom-like-text">Liked</span>
                                    @else
                                    <i class="ri-thumb-up-line"></i><span class="ms-1 custom-like-text">Like</span>
                                    @endif
                                </a>
                            </div>
                        </div>

                        <!-- STREM FOOTER -->
                        <!-- COMMENT ON THE POSTS -->
                        @foreach ($commentsByPost[$group_post->id] ?? [] as $comment)
                        <div class="ps-comments__list ps-js-comment-container ps-js-comment-container--1">
                            <div class="ps-comment ps-comment-item cstream-comment stream-comment ps-js-comment-item">
                                <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                    <a href="#" class="commentAvatar">
                                        <span style="color: rgb(218, 79, 32); font-size: 24px;">
                                            {{-- {{ strtoupper(substr($comment->userComment->first_name, 0, 1)) }} --}}
                                        </span>
                                    </a>
                                </div>
                                <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                    <div class="ps-comment__author">
                                        <a class="ps-tag__link ps-csr" href="#">
                                            {{-- {{ $comment->userComment->first_name . ' ' . $comment->userComment->last_name }} --}}
                                        </a>
                                    </div>
                                    <div class="ps-comment__content stream-comment-content ps-js-comment-content">
                                        {{ $comment->comment }}
                                    </div>
                                    <!-- Likes -->
                                    <div class="ps-comment__meta">
                                        <div class="ps-comment__info">
                                            <span class="activity-post-age activity-post-age-link">
                                                <a href="#">
                                                    <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                                </a>
                                            </span>
                                        </div>
                                        <!-- Like count for comments -->
                                        <div class="ps-comment__actions">
                                            <div>
                                                <a href="#" class="ps-comment__action ps-comment__action--like actaction-like" data-comment-id="{{ $comment->id }}" data-item-type="comment">
                                                    @auth
                                                    @if (auth()->user()->likedGroupComments->contains('comment_id', $comment->id))
                                                    <i class="ri-thumb-up-fill"></i><span class="ms-1 like-text">Liked</span>
                                                    @else
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                    @endif
                                                    @else
                                                    <!-- Handle case when user is not logged in -->
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                    @endauth
                                                    <span>
                                                        Liked by <span class="like-count"></span>
                                                    </span>
                                                </a>
                                            </div>
                                            <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Comment section -->
                                    <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                        <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        </a>
                                        <div class="ps-dropdown__menu  ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                            <a href="#" class="actaction-edit edit_btn" onclick="toggleEdit({{ $comment->id }})">
                                                <i class="ri-pencil-line"></i>
                                                <span class="ms-1">Edit</span>
                                            </a>
                                            <form action="{{ route('group.comments.delete', ['commentId' => $comment->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="comment_delete_btn">
                                                    <i class="ri-delete-bin-line"></i>
                                                    <span class="ms-1">Delete comment</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Edit comment form -->
                                    <div class="d-none editCommentArea" data-comment-id="{{ $comment->id }}">
                                        <form action="{{ route('group.comments.edit', ['commentId' => $comment->id]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="group_id" value="{{ $comment->groupPost->group_id }}">
                                            <textarea name="comment" placeholder="Edit comment ..." class="editTextarea d-block my-3">{{ $comment->comment }}</textarea>
                                            <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- reply section -->
                            <div id="wall-cmt-2" class="ps-comments ps-comments--nested ps-comment-nested">
                                @foreach ($comment->replies as $reply)
                                <div class="ps-comments__list">
                                    <div class="ps-comment ps-comment-item cstream-comment stream-comment">
                                        <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                            <a href="#" class="repliesAvatar">
                                                <span style="color: goldenrod; font-size: 24px;">
                                                    {{-- {{ strtoupper(substr($reply->user->first_name, 0, 1)) }} --}}
                                                </span>
                                            </a>
                                        </div>

                                        <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                            <div class="ps-comment__author">
                                                <a class="ps-tag__link ps-csr" href="#" data-hover-card="4">
                                                    {{-- {{ $reply->user->first_name . ' ' . $reply->user->last_name }} --}}
                                                </a>
                                            </div>
                                            <div class="ps-comment__content stream-comment-content">
                                                {{ $reply->comment }}
                                            </div>

                                            <div class="ps-comment__meta">
                                                <div class="ps-comment__info">
                                                    <span class="activity-post-age activity-post-age-link">
                                                        <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                                                    </span>
                                                </div>

                                                <!-- Like replies and count -->
                                                <div class="ps-comment__actions">
                                                    <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply replies-like" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                        <span class="reply-like-count">Liked by
                                                        </span>
                                                    </a>
                                                    <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                        @auth
                                                        @if (auth()->user()->likedGroupComments->contains('comment_id', $reply->id))
                                                        <i class="ri-thumb-up-fill"></i><span class="ms-1">Liked</span>
                                                        @else
                                                        <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                        @endif
                                                        @else
                                                        <!-- Handle case when user is not logged in -->
                                                        <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                        @endauth
                                                    </a>
                                                    <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                        <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- Reply section -->
                                            <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                                <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink6" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                </a>

                                                <div class="ps-dropdown__menu ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink6">
                                                    <a href="#" class="actaction-edit edit_reply_btn" onclick="toggleEditReply({{ $reply->id }})">
                                                        <i class="ri-pencil-line"></i>
                                                        <span class="ms-1">Edit</span>
                                                    </a>
                                                    <form action="{{ route('group.reply.delete', ['replyId' => $reply->id]) }}" method="POST" class="delete_replies">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="" class="comment_delete_btn">
                                                            <i class="ri-delete-bin-line"></i>
                                                            <span class="ms-1">Delete
                                                                reply</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Edit reply form -->
                                            <div class="d-none editReplyArea" data-reply-id="{{ $reply->id }}">
                                                <form action="{{ route('reply.edit', ['replyId' => $reply->id]) }}" method="POST">
                                                    @csrf
                                                    <textarea name="content" placeholder="Edit reply ..." class="editTextarea d-block my-3">{{ $reply->comment }}</textarea>
                                                    <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                        Reply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @if (!empty($comment->comment))
                                <form action="{{ route('group.post.comment.reply', ['commentId' => $comment->id]) }}" class="w-100" method="post">
                                    @csrf
                                    <div class="ps-comments__reply ps-comment-reply cstream-form stream-form wallform ps-js-comment-new">
                                        <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
                                            <div class="ps-postbox__input-tag">
                                                <textarea data-act-id="3" class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a reply..." style="height: 40px;"></textarea>
                                            </div>
                                        </div>
                                        <div class="ps-comments__reply-send ps-comment-send cstream-form-submit">
                                            <div class="ps-comments__reply-actions ps-comment-actions">
                                                <!--<button-->
                                                <!--    class="ps-btn ps-button-cancel">Clear</button>-->
                                                <!--<input type="hidden" name="type"-->
                                                <!--    value="reply" class="form-control">-->
                                                <!--<button-->
                                                class="ps-btn ps-btn--action ps-button-action"
                                                type="submit">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>

                        </div>
                        @endforeach
                        <!-- WRITE COMMENT AREA -->
                        <form action="{{ route('dashboard.group.post.comment', ['id' => $group_post->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="group_id" value="{{ $group_post->group_id }}">
                            <div id="act-new-comment-{{ $group_post->id }}" class="ps-comments__reply cstream-form stream-form wallform ps-js-comment-new ps-js-newcomment-1">
                                <a class="ps-avatar cstream-avatar cstream-author me-2" href="#">
                                    <a href="#" class="repliesAvatar">
                                        <span style="color: goldenrod; font-size: 24px;">
                                            {{-- {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }} --}}
                                        </span>
                                    </a>
                                </a>
                                <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input me-2">
                                    <div class="ps-postbox__input-tag">
                                        <textarea class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a comment..." style="height: 42px;" id="postTextArea{{ $group_post->id }}"></textarea>
                                    </div>
                                </div>
                                <div class="ps-comments__reply-send cstream-form-submit">
                                    <div class="ps-comments__reply-actions ps-comment-actions">
                                        <!--<button class="ps-btn ps-button-cancel"-->
                                        <!--    onclick="clearTextArea('postTextArea{{ $group_post->id }}')"-->
                                        <!--    type="button">Clear</button>-->
                                        <input type="hidden" name="type" value="text" class="form-control">
                                        <button class="ps-btn ps-btn--action ps-btn-primary ps-button-action" type="submit">Post</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @elseif ($group_post->type == 'file')
                    <div>
                        <!-- POST HEADER -->
                        <div class="ps-post__header ps-js-post-header">
                            <a class="ps-avatar ps-avatar--post" href="{{ route('user.about') }}">
                                <div class="d-flex justify-content-center align-items-center text-center" style="width: 61px; height: 61px; border-radius: 50%; background-color: #e9e9e9;">
                                    @if ($group_post->user)
                                    <span style="font-size: 48px; font-weight: bold; color: #c2a006;">
                                        {{ substr($group_post->user->first_name, 0, 1) }}
                                    </span>
                                    @else
                                    <span style="font-size: 16px; font-weight: bold; color: #c2a006;">N/A</span>
                                    @endif
                                </div>
                            </a>
                            <div class="ps-post__meta">
                                <div class="ps-post__info">
                                    <a class="ps-post__date ps-js-timestamp" href="#">
                                        <span class="ps-js-autotime" title="{{ \Carbon\Carbon::parse($group_post->created_at)->format('F d, Y g:i a') }}">
                                            {{ \Carbon\Carbon::parse($group_post->created_at)->diffForHumans() }}
                                        </span>
                                    </a>
                                    <div class="ps-post__privacy ps-dropdown ps-dropdown--privacy ps-js-dropdown ps-privacy--21" title="Post privacy">
                                        <a href="#" class="dropdown-toggle ps-post__privacy-toggle ps-dropdown_toggle ms-3" role="button" id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-team-fill"></i><span class="ms-1">Site
                                                Members</span>
                                        </a>
                                        <div class="ps-dropdown__menu ps-dropdown-menu dropdown-menu posts-dropdown-menu" aria-labelledby="dropdownMenuLink3">
                                            <a href="#"><i class="ri-earth-fill"></i><span class="ms-1">Public</span></a>
                                            <a href="#"><i class="ri-team-fill"></i><span class="ms-1">Site
                                                    Members</span></a>
                                            <a href="#"><i class="ri-user-fill"></i><span class="ms-1">Friends
                                                    Only</span></a>
                                            <a href="#"><i class="ri-lock-fill"></i><span class="ms-1">Only
                                                    Me</span></a>
                                        </div>
                                    </div>
                                    <a class="ps-post__copy" href="#"><span class="ps-tooltip ps-tooltip--permalink" data-tooltip="Click to copy" data-tooltip-initial="Click to copy" data-tooltip-success="Copied."><i class="gcis gci-link"></i></span></a>
                                </div>
                            </div>

                            <div class="ps-post__options ps-js-post-options">
                                <div class="ps-post__options-menu ps-js-dropdown">
                                    <a href="#" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    </a>
                                    <div class="dropdown-menu ps-dropdown__menu ps-js-dropdown-menu" aria-labelledby="dropdownMenuLink4">
                                        <a href="#">
                                            <i class="ri-pencil-line"></i><span class="ms-1">Edit</span>
                                        </a>
                                        <a href="#">
                                            <i class="ri-delete-bin-line"></i><span class="ms-1">Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- POST BODY -->
                        <div class="ps-media ps-media--iframe ps-media-iframe ps-js-video">
                            <div class="wp-video mx-3 my-4">
                                {{ $group_post->file_details }}
                            </div>
                            <div class="wp-video mx-3 my-4">
                                <a href="{{ $group_post->file }}" target="_blank">{{ $group_post->file_name }}</a>
                            </div>

                            <!-- like button for posts -->
                            <div class="wp-video mx-3 mt-3">
                                <a href="#" class="group-post-like" data-post-type="text" data-post-id="{{ $group_post->id }}">
                                    @if (auth()->user()->hasLikedGroupPost($group_post))
                                    <i class="ri-thumb-up-fill"></i><span class="ms-1 custom-like-text">Liked</span>
                                    @else
                                    <i class="ri-thumb-up-line"></i><span class="ms-1 custom-like-text">Like</span>
                                    @endif
                                </a>
                            </div>
                        </div>

                        <!-- STREM FOOTER -->
                        <!-- COMMENT ON THE POSTS -->
                        @foreach ($commentsByPost[$group_post->id] ?? [] as $comment)
                        <div class="ps-comments__list ps-js-comment-container ps-js-comment-container--1">
                            <div class="ps-comment ps-comment-item cstream-comment stream-comment ps-js-comment-item">
                                <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                    <a href="#" class="commentAvatar">
                                        <span style="color: rgb(218, 79, 32); font-size: 24px;">
                                            {{-- {{ strtoupper(substr($comment->userComment->first_name, 0, 1)) }} --}}
                                        </span>
                                    </a>
                                </div>
                                <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                    <div class="ps-comment__author">
                                        <a class="ps-tag__link ps-csr" href="#">
                                            {{-- {{ $comment->userComment->first_name . ' ' . $comment->userComment->last_name }} --}}
                                        </a>
                                    </div>
                                    <div class="ps-comment__content stream-comment-content ps-js-comment-content">
                                        {{ $comment->comment }}
                                    </div>
                                    <!-- Likes -->
                                    <div class="ps-comment__meta">
                                        <div class="ps-comment__info">
                                            <span class="activity-post-age activity-post-age-link">
                                                <a href="#">
                                                    <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                                </a>
                                            </span>
                                        </div>

                                        <!-- Like count for comments -->
                                        <div class="ps-comment__actions">
                                            <div>
                                                <a href="#" class="ps-comment__action ps-comment__action--like actaction-like" data-comment-id="{{ $comment->id }}" data-item-type="comment">
                                                    @auth
                                                    @if (auth()->user()->likedGroupComments->contains('comment_id', $comment->id))
                                                    <i class="ri-thumb-up-fill"></i><span class="ms-1 like-text">Liked</span>
                                                    @else
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                    @endif
                                                    @else
                                                    <!-- Handle case when user is not logged in -->
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                    @endauth
                                                    <span>
                                                        Liked by <span class="like-count"></span>
                                                    </span>
                                                </a>
                                            </div>
                                            <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Comment section -->
                                    <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                        <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        </a>
                                        <div class="ps-dropdown__menu  ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                            <a href="#" class="actaction-edit edit_btn" onclick="toggleEdit({{ $comment->id }})">
                                                <i class="ri-pencil-line"></i>
                                                <span class="ms-1">Edit</span>
                                            </a>
                                            <form action="{{ route('group.comments.delete', ['commentId' => $comment->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="comment_delete_btn">
                                                    <i class="ri-delete-bin-line"></i>
                                                    <span class="ms-1">Delete comment</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Edit comment form -->
                                    <div class="d-none editCommentArea" data-comment-id="{{ $comment->id }}">
                                        <form action="{{ route('group.comments.edit', ['commentId' => $comment->id]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="group_id" value="{{ $comment->groupPost->group_id }}">
                                            <textarea name="comment" placeholder="Edit comment ..." class="editTextarea d-block my-3">{{ $comment->comment }}</textarea>
                                            <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="wall-cmt-2" class="ps-comments ps-comments--nested ps-comment-nested">
                                @foreach ($comment->replies as $reply)
                                <div class="ps-comments__list">
                                    <div class="ps-comment ps-comment-item cstream-comment stream-comment">
                                        <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                            <a href="#" class="repliesAvatar">
                                                <span style="color: goldenrod; font-size: 24px;">
                                                    {{-- {{ strtoupper(substr($reply->user->first_name, 0, 1)) }} --}}
                                                </span>
                                            </a>
                                        </div>

                                        <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                            <div class="ps-comment__author">
                                                <a class="ps-tag__link ps-csr" href="#" data-hover-card="4">
                                                    {{-- {{ $reply->user->first_name . ' ' . $reply->user->last_name }} --}}
                                                </a>
                                            </div>
                                            <div class="ps-comment__content stream-comment-content">
                                                {{ $reply->comment }}
                                            </div>

                                            <div class="ps-comment__meta">
                                                <div class="ps-comment__info">
                                                    <span class="activity-post-age activity-post-age-link">
                                                        <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                                                    </span>
                                                </div>

                                                <!-- Like replies -->
                                                <!-- reply like count -->
                                                <div class="ps-comment__actions">
                                                    <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply replies-like" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                        <span class="reply-like-count">Liked by
                                                            {{ $reply->likeCount }}</span>
                                                    </a>
                                                    <a href="#" class="ps-comment__action ps-comment__action--like actaction-like" data-comment-id="{{ $comment->id }}" data-item-type="comment">
                                                        @if (auth()->user()->hasLikedGroupComment($comment))
                                                        <i class="ri-thumb-up-fill"></i><span class="ms-1">Liked</span>
                                                        @else
                                                        <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                        @endif
                                                    </a>
                                                    <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                        <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Reply section -->
                                            <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                                <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink6" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                </a>

                                                <div class="ps-dropdown__menu ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink6">
                                                    <a href="#" class="actaction-edit edit_reply_btn" onclick="toggleEditReply({{ $reply->id }})">
                                                        <i class="ri-pencil-line"></i>
                                                        <span class="ms-1">Edit</span>
                                                    </a>
                                                    <form action="{{ route('group.reply.delete', ['replyId' => $reply->id]) }}" method="POST" class="delete_replies">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="" class="comment_delete_btn">
                                                            <i class="ri-delete-bin-line"></i>
                                                            <span class="ms-1">Delete
                                                                reply</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Edit reply form -->
                                            <div class="d-none editReplyArea" data-reply-id="{{ $reply->id }}">
                                                <form action="{{ route('reply.edit', ['replyId' => $reply->id]) }}" method="POST">
                                                    @csrf
                                                    <textarea name="content" placeholder="Edit reply ..." class="editTextarea d-block my-3">{{ $reply->comment }}</textarea>
                                                    <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                        Reply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @if (!empty($comment->content))
                                <form action="{{ route('group.post.comment.reply', ['commentId' => $comment->id]) }}" class="w-100" method="post">
                                    @csrf
                                    <div class="ps-comments__reply ps-comment-reply cstream-form stream-form wallform ps-js-comment-new">
                                        <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
                                            <div class="ps-postbox__input-tag">
                                                <textarea data-act-id="3" class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a reply..." style="height: 40px;"></textarea>
                                            </div>
                                        </div>
                                        <div class="ps-comments__reply-send ps-comment-send cstream-form-submit">
                                            <div class="ps-comments__reply-actions ps-comment-actions">
                                                <!--<button-->
                                                <!--    class="ps-btn ps-button-cancel">Clear</button>-->
                                                <!--<input type="hidden" name="type"-->
                                                <!--    value="reply" class="form-control">-->
                                                <!--<button-->
                                                class="ps-btn ps-btn--action ps-button-action"
                                                type="submit">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <!-- WRITE COMMENT AREA -->
                        <form action="{{ route('dashboard.group.post.comment', ['id' => $group_post->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="group_id" value="{{ $group_post->id }}">
                            <div id="act-new-comment-{{ $group_post->id }}" class="ps-comments__reply cstream-form stream-form wallform ps-js-comment-new ps-js-newcomment-1">
                                <a class="ps-avatar cstream-avatar cstream-author me-2" href="#">
                                    <a href="#" class="repliesAvatar">
                                        <span style="color: goldenrod; font-size: 24px;">
                                            {{-- {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }} --}}
                                        </span>
                                    </a>
                                </a>
                                <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input me-2">
                                    <div class="ps-postbox__input-tag">
                                        <textarea class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a comment..." style="height: 42px;" id="postTextArea{{ $group_post->id }}"></textarea>
                                    </div>
                                </div>
                                <div class="ps-comments__reply-send cstream-form-submit">
                                    <div class="ps-comments__reply-actions ps-comment-actions">
                                        <!--<button class="ps-btn ps-button-cancel"-->
                                        <!--    onclick="clearTextArea('postTextArea{{ $group_post->id }}')"-->
                                        <!--    type="button">Clear</button>-->
                                        <!--<input type="hidden" name="type" value="text"-->
                                        <!--    class="form-control">-->
                                        <!--<button-->
                                        class="ps-btn ps-btn--action ps-btn-primary ps-button-action"
                                        type="submit">Post</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @elseif ($group_post->type == 'gif' && $group_post->gif_url !== null && $group_post->gif_url !== '')
                    <div>
                        <!-- POST HEADER -->
                        <div class="ps-post__header ps-js-post-header">
                            <a class="ps-avatar ps-avatar--post" href="{{ route('user.about') }}">
                                <div class="d-flex justify-content-center align-items-center text-center" style="width: 61px; height: 61px; border-radius: 50%; background-color: #e9e9e9;">
                                    @if ($group_post->user)
                                    <span style="font-size: 48px; font-weight: bold; color: #c2a006;">
                                        {{ substr($group_post->user->first_name, 0, 1) }}
                                    </span>
                                    @else
                                    <span style="font-size: 16px; font-weight: bold; color: #c2a006;">N/A</span>
                                    @endif
                                </div>
                            </a>
                            <div class="ps-post__meta">
                                <div class="ps-post__info">
                                    <a class="ps-post__date ps-js-timestamp" href="#">
                                        <span class="ps-js-autotime" title="{{ \Carbon\Carbon::parse($group_post->created_at)->format('F d, Y g:i a') }}">
                                            {{ \Carbon\Carbon::parse($group_post->created_at)->diffForHumans() }}
                                        </span>
                                    </a>
                                    <div class="ps-post__privacy ps-dropdown ps-dropdown--privacy ps-js-dropdown ps-privacy--21" title="Post privacy">
                                        <a href="#" class="dropdown-toggle ps-post__privacy-toggle ps-dropdown_toggle ms-3" role="button" id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-team-fill"></i><span class="ms-1">Site
                                                Members</span>
                                        </a>
                                        <div class="ps-dropdown__menu ps-dropdown-menu dropdown-menu posts-dropdown-menu" aria-labelledby="dropdownMenuLink3">
                                            <a href="#"><i class="ri-earth-fill"></i><span class="ms-1">Public</span></a>
                                            <a href="#"><i class="ri-team-fill"></i><span class="ms-1">Site
                                                    Members</span></a>
                                            <a href="#"><i class="ri-user-fill"></i><span class="ms-1">Friends
                                                    Only</span></a>
                                            <a href="#"><i class="ri-lock-fill"></i><span class="ms-1">Only
                                                    Me</span></a>
                                        </div>
                                    </div>
                                    <a class="ps-post__copy" href="#"><span class="ps-tooltip ps-tooltip--permalink" data-tooltip="Click to copy" data-tooltip-initial="Click to copy" data-tooltip-success="Copied."><i class="gcis gci-link"></i></span></a>
                                </div>
                            </div>

                            <div class="ps-post__options ps-js-post-options">
                                <div class="ps-post__options-menu ps-js-dropdown">
                                    <a href="#" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    </a>
                                    <div class="dropdown-menu ps-dropdown__menu ps-js-dropdown-menu" aria-labelledby="dropdownMenuLink4">
                                        <a href="#">
                                            <i class="ri-pencil-line"></i><span class="ms-1">Edit</span>
                                        </a>
                                        <a href="#">
                                            <i class="ri-delete-bin-line"></i><span class="ms-1">Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- POST BODY -->
                        <div class="ps-media ps-media--iframe ps-media-iframe ps-js-video">
                            <div class="wp-video mx-3 my-4 text-center">
                                <img src="{{ $group_post->gif_url }}" alt="GIF" class="img-fluid my-2" width="150">
                            </div>

                            <!-- like button for posts -->
                            <div class="wp-video mx-3 mt-3">
                                <a href="#" class="group-post-like" data-post-type="text" data-post-id="{{ $group_post->id }}">
                                    @if (auth()->user()->hasLikedGroupPost($group_post))
                                    <i class="ri-thumb-up-fill"></i><span class="ms-1 custom-like-text">Liked</span>
                                    @else
                                    <i class="ri-thumb-up-line"></i><span class="ms-1 custom-like-text">Like</span>
                                    @endif
                                </a>
                            </div>
                        </div>

                        <!-- STREM FOOTER -->
                        <!-- COMMENT ON THE POSTS -->
                        @foreach ($commentsByPost[$group_post->id] ?? [] as $comment)
                        <div class="ps-comments__list ps-js-comment-container ps-js-comment-container--1">
                            <div class="ps-comment ps-comment-item cstream-comment stream-comment ps-js-comment-item">
                                <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                    <a href="#" class="commentAvatar">
                                        <span style="color: rgb(218, 79, 32); font-size: 24px;">
                                            {{-- {{ strtoupper(substr($comment->userComment->first_name, 0, 1)) }} --}}
                                        </span>
                                    </a>
                                </div>
                                <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                    <div class="ps-comment__author">
                                        <a class="ps-tag__link ps-csr" href="#">
                                            {{-- {{ $comment->userComment->first_name . ' ' . $comment->userComment->last_name }} --}}
                                        </a>
                                    </div>
                                    <div class="ps-comment__content stream-comment-content ps-js-comment-content">
                                        {{ $comment->comment }}
                                    </div>
                                    <!-- Likes -->
                                    <div class="ps-comment__meta">
                                        <div class="ps-comment__info">
                                            <span class="activity-post-age activity-post-age-link">
                                                <a href="#">
                                                    <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                                </a>
                                            </span>
                                        </div>

                                        <!-- Like count for comments -->
                                        <div class="ps-comment__actions">
                                            <div>
                                                <a href="#" class="ps-comment__action ps-comment__action--like actaction-like" data-comment-id="{{ $comment->id }}" data-item-type="comment">
                                                    @auth
                                                    @if (auth()->user()->likedGroupComments->contains('comment_id', $comment->id))
                                                    <i class="ri-thumb-up-fill"></i><span class="ms-1 like-text">Liked</span>
                                                    @else
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                    @endif
                                                    @else
                                                    <!-- Handle case when user is not logged in -->
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                    @endauth
                                                    <span>
                                                        Liked by <span class="like-count"></span>
                                                    </span>
                                                </a>
                                            </div>
                                            <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Comment section -->
                                    <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                        <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        </a>
                                        <div class="ps-dropdown__menu  ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                            <a href="#" class="actaction-edit edit_btn" onclick="toggleEdit({{ $comment->id }})">
                                                <i class="ri-pencil-line"></i>
                                                <span class="ms-1">Edit</span>
                                            </a>
                                            <form action="{{ route('group.comments.delete', ['commentId' => $comment->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="comment_delete_btn">
                                                    <i class="ri-delete-bin-line"></i>
                                                    <span class="ms-1">Delete comment</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Edit comment form -->
                                    <div class="d-none editCommentArea" data-comment-id="{{ $comment->id }}">
                                        <form action="{{ route('group.comments.edit', ['commentId' => $comment->id]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="group_id" value="{{ $comment->groupPost->group_id }}">
                                            <textarea name="comment" placeholder="Edit comment ..." class="editTextarea d-block my-3">{{ $comment->comment }}</textarea>
                                            <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="wall-cmt-2" class="ps-comments ps-comments--nested ps-comment-nested">
                                @foreach ($comment->replies as $reply)
                                <div class="ps-comments__list">
                                    <div class="ps-comment ps-comment-item cstream-comment stream-comment">
                                        <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                            <a href="#" class="repliesAvatar">
                                                <span style="color: goldenrod; font-size: 24px;">
                                                    {{-- {{ strtoupper(substr($reply->user->first_name, 0, 1)) }} --}}
                                                </span>
                                            </a>
                                        </div>

                                        <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                            <div class="ps-comment__author">
                                                <a class="ps-tag__link ps-csr" href="#" data-hover-card="4">
                                                    {{-- {{ $reply->user->first_name . ' ' . $reply->user->last_name }} --}}
                                                </a>
                                            </div>
                                            <div class="ps-comment__content stream-comment-content">
                                                {{ $reply->comment }}
                                            </div>

                                            <div class="ps-comment__meta">
                                                <div class="ps-comment__info">
                                                    <span class="activity-post-age activity-post-age-link">
                                                        <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                                                    </span>
                                                </div>

                                                <!-- Like replies and count -->
                                                <div class="ps-comment__actions">
                                                    <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply replies-like" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                        <span class="reply-like-count">Liked by
                                                        </span>
                                                    </a>
                                                    <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                        @auth
                                                        @if (auth()->user()->likedGroupComments->contains('comment_id', $reply->id))
                                                        <i class="ri-thumb-up-fill"></i><span class="ms-1">Liked</span>
                                                        @else
                                                        <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                        @endif
                                                        @else
                                                        <!-- Handle case when user is not logged in -->
                                                        <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                        @endauth
                                                    </a>
                                                    <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                        <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- Reply section -->
                                            <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                                <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink6" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                </a>

                                                <div class="ps-dropdown__menu ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink6">
                                                    <a href="#" class="actaction-edit edit_reply_btn" onclick="toggleEditReply({{ $reply->id }})">
                                                        <i class="ri-pencil-line"></i>
                                                        <span class="ms-1">Edit</span>
                                                    </a>
                                                    <form action="{{ route('group.reply.delete', ['replyId' => $reply->id]) }}" method="POST" class="delete_replies">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="" class="comment_delete_btn">
                                                            <i class="ri-delete-bin-line"></i>
                                                            <span class="ms-1">Delete
                                                                reply</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Edit reply form -->
                                            <div class="d-none editReplyArea" data-reply-id="{{ $reply->id }}">
                                                <form action="{{ route('reply.edit', ['replyId' => $reply->id]) }}" method="POST">
                                                    @csrf
                                                    <textarea name="content" placeholder="Edit reply ..." class="editTextarea d-block my-3">{{ $reply->comment }}</textarea>
                                                    <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                        Reply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <!-- Reply Form -->
                                @if (!empty($comment->content))
                                <form action="{{ route('group.post.comment.reply', ['commentId' => $comment->id]) }}" class="w-100" method="post">
                                    @csrf
                                    <div class="ps-comments__reply ps-comment-reply cstream-form stream-form wallform ps-js-comment-new">
                                        <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
                                            <div class="ps-postbox__input-tag">
                                                <textarea data-act-id="3" class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a reply..." style="height: 40px;"></textarea>
                                            </div>
                                        </div>
                                        <div class="ps-comments__reply-send ps-comment-send cstream-form-submit">
                                            <div class="ps-comments__reply-actions ps-comment-actions">
                                                <!--<button-->
                                                <!--    class="ps-btn ps-button-cancel">Clear</button>-->
                                                <!--<input type="hidden" name="type"-->
                                                <!--    value="reply" class="form-control">-->
                                                <!--<button-->
                                                class="ps-btn ps-btn--action ps-button-action"
                                                type="submit">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach


                        <!-- WRITE COMMENT AREA -->
                        <form action="{{ route('dashboard.group.post.comment', ['id' => $group_post->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="group_id" value="{{ $group_post->group_id }}">
                            <div id="act-new-comment-{{ $group_post->id }}" class="ps-comments__reply cstream-form stream-form wallform ps-js-comment-new ps-js-newcomment-1">
                                <a class="ps-avatar cstream-avatar cstream-author me-2" href="#">
                                    <a href="#" class="repliesAvatar">
                                        <span style="color: goldenrod; font-size: 24px;">
                                            {{-- {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }} --}}
                                        </span>
                                    </a>
                                </a>
                                <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input me-2">
                                    <div class="ps-postbox__input-tag">
                                        <textarea class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a comment..." style="height: 42px;" id="postTextArea{{ $group_post->id }}"></textarea>
                                    </div>
                                </div>
                                <div class="ps-comments__reply-send cstream-form-submit">
                                    <div class="ps-comments__reply-actions ps-comment-actions">
                                        <!--<button class="ps-btn ps-button-cancel"-->
                                        <!--    onclick="clearTextArea('postTextArea{{ $group_post->id }}')"-->
                                        <!--    type="button">Clear</button>-->
                                        <!--<input type="hidden" name="type" value="text"-->
                                        <!--    class="form-control">-->
                                        <!--<button-->
                                        class="ps-btn ps-btn--action ps-btn-primary ps-button-action"
                                        type="submit">Post</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach
@endif

@if (!$grouped_media->isEmpty())
<section class="ps-activity_container">
    <div class="container">
        <div id="ps-activitystream" class="ps-posts ps-posts-narrow">
            <div class="ps-post ps-activity ps-activity-post-1">
                <div id="all_group_posts">
                    @foreach ($grouped_media as $batchNumber => $posts)
                    @if ($posts->isNotEmpty())
                    <!-- Separate conditional section for media -->
                    <div class="media-section row p-4">
                        @foreach ($posts as $group_post)
                        @if ($group_post->type === 'Video' && $group_post->media_url)
                        <div class="col-md-4">
                            <video width="320" height="240" controls>
                                <source src="{{ $group_post->media_url }}" type="video/mp4">
                                <source src="{{ $group_post->media_url }}" type="video/avi">
                                <source src="{{ $group_post->media_url }}" type="video/wmv">
                                <source src="{{ $group_post->media_url }}" type="video/mov">
                                <source src="{{ $group_post->media_url }}" type="video/mkv">
                                <source src="{{ $group_post->media_url }}" type="video/flv">
                                <source src="{{ $group_post->media_url }}" type="video/3gpp">
                                <source src="{{ $group_post->media_url }}" type="video/mpeg">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        @elseif ($group_post->type === 'Image' && $group_post->media_url)
                        <div class="col-12">
                            <div class="image-gallery">
                                <img src="{{ $group_post->media_url }}" alt="Image" class="img-fluid lightbox-trigger" data-index="{{ $loop->index }}" data-target="#imageModal" data-toggle="modal">
                            </div>
                        </div>
                        @endif

                        @endforeach
                        <div class="col-12">
                            <div class="image-gallery-2">
                                <img src="../../assets/images/cleaning.png" alt="Image" class="img-fluid lightbox-trigger" data-index="" data-target="#imageModal" data-toggle="modal">
                                <img src="../../assets/images/img1.jpg" alt="Image" class="img-fluid lightbox-trigger" data-index="" data-target="#imageModal" data-toggle="modal">
                                <img src="../../assets/images/img2.jpg" alt="Image" class="img-fluid lightbox-trigger" data-index="" data-target="#imageModal" data-toggle="modal">
                            </div>
                        </div>
                        <!-- like button for posts -->
                        <div class="wp-video mx-3 mt-3">
                            <a href="#" class="group-media-like" data-post-type="text" data-post-id="{{ $group_post->media_batch_number }}">
                                @if (auth()->user()->hasLikedGroupMedia($group_post))
                                <i class="ri-thumb-up-fill"></i><span class="ms-1 custom-like-text">Liked</span>
                                @else
                                <i class="ri-thumb-up-line"></i><span class="ms-1 custom-like-text">Like</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- STREM FOOTER -->
                    <!-- COMMENT ON THE POSTS -->
                    @foreach ($commentsByPost[$group_post->id] ?? [] as $comment)
                    <div class="ps-comments__list ps-js-comment-container ps-js-comment-container--1">
                        <div class="ps-comment ps-comment-item cstream-comment stream-comment ps-js-comment-item">
                            <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                <a href="#" class="commentAvatar">
                                    <span style="color: rgb(218, 79, 32); font-size: 24px;">
                                        {{-- {{ strtoupper(substr($comment->userComment->first_name, 0, 1)) }} --}}
                                    </span>
                                </a>
                            </div>
                            <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                <div class="ps-comment__author">
                                    <a class="ps-tag__link ps-csr" href="#">
                                        {{-- {{ $comment->userComment->first_name . ' ' . $comment->userComment->last_name }} --}}
                                    </a>
                                </div>
                                <div class="ps-comment__content stream-comment-content ps-js-comment-content">
                                    {{ $comment->comment }}
                                </div>
                                <!-- Likes -->
                                <div class="ps-comment__meta">
                                    <div class="ps-comment__info">
                                        <span class="activity-post-age activity-post-age-link">
                                            <a href="#">
                                                <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                            </a>
                                        </span>
                                    </div>

                                    <!-- Like count for comments -->
                                    <div class="ps-comment__actions">
                                        <div>
                                            <a href="#" class="ps-comment__action ps-comment__action--like actaction-like" data-comment-id="{{ $comment->id }}" data-item-type="comment">
                                                @auth
                                                @if (auth()->user()->likedGroupComments->contains('comment_id', $comment->id))
                                                <i class="ri-thumb-up-fill"></i><span class="ms-1 like-text">Liked</span>
                                                @else
                                                <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                @endif
                                                @else
                                                <!-- Handle case when user is not logged in -->
                                                <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                @endauth
                                                <span>
                                                    Liked by <span class="like-count"></span>
                                                </span>
                                            </a>
                                        </div>
                                        <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                            <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Comment section -->
                                <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                    <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    </a>
                                    <div class="ps-dropdown__menu  ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                        <a href="#" class="actaction-edit edit_btn" onclick="toggleEdit({{ $comment->id }})">
                                            <i class="ri-pencil-line"></i>
                                            <span class="ms-1">Edit</span>
                                        </a>
                                        <form action="{{ route('group.comments.delete', ['commentId' => $comment->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="comment_delete_btn">
                                                <i class="ri-delete-bin-line"></i>
                                                <span class="ms-1">Delete comment</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit comment form -->
                                <div class="d-none editCommentArea" data-comment-id="{{ $comment->id }}">
                                    <form action="{{ route('group.comments.edit', ['commentId' => $comment->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="group_id" value="{{ $comment->groupPost->group_id }}">
                                        <textarea name="comment" placeholder="Edit comment ..." class="editTextarea d-block my-3">{{ $comment->comment }}</textarea>
                                        <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                            Comment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="wall-cmt-2" class="ps-comments ps-comments--nested ps-comment-nested">
                            @foreach ($comment->replies as $reply)
                            <div class="ps-comments__list">
                                <div class="ps-comment ps-comment-item cstream-comment stream-comment">
                                    <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                        <a href="#" class="repliesAvatar">
                                            @if ($reply->user)
                                            <span style="color: goldenrod; font-size: 24px;">
                                                {{ strtoupper(substr($reply->user->first_name, 0, 1)) }}
                                            </span>
                                            @else
                                            <!-- Handle the case where $reply->user is null -->
                                            <span style="color: goldenrod; font-size: 24px;">N/A</span>
                                            @endif
                                        </a>
                                    </div>

                                    <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                        <div class="ps-comment__author">
                                            <a class="ps-tag__link ps-csr" href="#" data-hover-card="4">
                                                @if ($reply->user)
                                                {{ $reply->user->first_name . ' ' . $reply->user->last_name }}
                                                @else
                                                Anonymous
                                                @endif
                                            </a>

                                        </div>
                                        <div class="ps-comment__content stream-comment-content">
                                            {{ $reply->comment }}
                                        </div>

                                        <div class="ps-comment__meta">
                                            <div class="ps-comment__info">
                                                <span class="activity-post-age activity-post-age-link">
                                                    <span class="ps-js-autotime">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                                                </span>
                                            </div>

                                            <!-- Like replies and count -->
                                            <div class="ps-comment__actions">
                                                <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply replies-like" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                    <span class="reply-like-count">Liked by </span>
                                                </a>
                                                <a href="#" class="ps-comment__action ps-comment__action--like actaction-like-reply" data-reply-id="{{ $reply->id }}" data-item-type="reply">
                                                    @auth
                                                    @if (auth()->user()->likedGroupComments->contains('comment_id', $reply->id))
                                                    <i class="ri-thumb-up-fill"></i><span class="ms-1">Liked</span>
                                                    @else
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                    @endif
                                                    @else
                                                    <!-- Handle case when user is not logged in -->
                                                    <i class="ri-thumb-up-line"></i><span class="ms-1">Like</span>
                                                    @endauth
                                                </a>
                                                <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                    <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- Reply section -->
                                        <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                            <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink6" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </a>

                                            <div class="ps-dropdown__menu ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink6">
                                                <a href="#" class="actaction-edit edit_reply_btn" onclick="toggleEditReply({{ $reply->id }})">
                                                    <i class="ri-pencil-line"></i>
                                                    <span class="ms-1">Edit</span>
                                                </a>
                                                <form action="{{ route('group.reply.delete', ['replyId' => $reply->id]) }}" method="POST" class="delete_replies">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="" class="comment_delete_btn">
                                                        <i class="ri-delete-bin-line"></i>
                                                        <span class="ms-1">Delete reply</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Edit reply form -->
                                        <div class="d-none editReplyArea" data-reply-id="{{ $reply->id }}">
                                            <form action="{{ route('reply.edit', ['replyId' => $reply->id]) }}" method="POST">
                                                @csrf
                                                <textarea name="content" placeholder="Edit reply ..." class="editTextarea d-block my-3">{{ $reply->comment }}</textarea>
                                                <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                    Reply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if (!empty($comment->comment))
                            <form action="{{ route('group.post.comment.reply', ['commentId' => $comment->id]) }}" class="w-100" method="post">
                                @csrf
                                <div class="ps-comments__reply ps-comment-reply cstream-form stream-form wallform ps-js-comment-new">
                                    <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
                                        <div class="ps-postbox__input-tag">
                                            <textarea data-act-id="3" class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a reply..." style="height: 40px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="ps-comments__reply-send ps-comment-send cstream-form-submit">
                                        <div class="ps-comments__reply-actions ps-comment-actions">
                                            <!--<button class="ps-btn ps-button-cancel">Clear</button>-->
                                            <input type="hidden" name="type" value="reply" class="form-control">
                                            <button class="ps-btn ps-btn--action ps-button-action" type="submit">Post</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- WRITE COMMENT AREA -->
                    <form action="{{ route('dashboard.group.post.comment', ['id' => $group_post->id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $group_post->id }}">
                        <div id="act-new-comment-{{ $group_post->id }}" class="ps-comments__reply cstream-form stream-form wallform ps-js-comment-new ps-js-newcomment-1">
                            <a class="ps-avatar cstream-avatar cstream-author me-2" href="#">
                                <a href="#" class="repliesAvatar">
                                    <span style="color: goldenrod; font-size: 24px;">
                                        {{-- {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }} --}}
                                    </span>
                                </a>
                            </a>
                            <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input me-2">
                                <div class="ps-postbox__input-tag">
                                    <textarea class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a comment..." style="height: 42px;" id="postTextArea{{ $group_post->id }}"></textarea>
                                </div>
                            </div>
                            <div class="ps-comments__reply-send cstream-form-submit">
                                <div class="ps-comments__reply-actions ps-comment-actions">
                                    <!--<button class="ps-btn ps-button-cancel"-->
                                    <!--    onclick="clearTextArea('postTextArea{{ $group_post->id }}')"-->
                                    <!--    type="button">Clear</button>-->
                                    <button class="ps-btn ps-btn--action ps-btn-primary ps-button-action" type="submit">Post</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach

                    <!-- Image Preview Modal -->
                    <div class="modal fade myModal" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!--<div class="modal-header">-->
                                <!--    <h4 class="modal-title" id="imageModalLabel">Image Preview-->
                                <!--    </h4>-->
                                <!--</div>-->
                                <div class="modal-body text-center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img id="lightboxImage" class="img-fluid" alt="Preview Image">
                                        </div>
                                        <div class="col-md-6">
                                            @foreach ($commentsByPost[$group_post->id] ?? [] as $comment)
                                            <div class="ps-comments__list ps-js-comment-container ps-js-comment-container--1">
                                                <div class="ps-comment ps-comment-item cstream-comment stream-comment ps-js-comment-item">
                                                    <div class="ps-comment__avatar ps-avatar ps-avatar--comment">
                                                        <a href="#" class="commentAvatar">
                                                            <span style="color: rgb(218, 79, 32); font-size: 24px;">

                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="ps-comment__body js-stream-content ps-js-comment-body">
                                                        <div class="ps-comment__author">
                                                            <a class="ps-tag__link ps-csr" href="#">

                                                            </a>
                                                        </div>
                                                        <div class="ps-comment__content stream-comment-content ps-js-comment-content">
                                                            {{ $comment->comment }}
                                                        </div>


                                                        <!-- Comment section -->
                                                        <div class="ps-comment__actions-dropdown ps-dropdown--left ps-js-dropdown">
                                                            <a href="javascript:" class="dropdown-toggle ps-dropdown__toggle ps-js-dropdown-toggle" id="dropdownMenuLink5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            </a>
                                                            <div class="ps-dropdown__menu  ps-js-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                                                <a href="#" class="actaction-edit edit_btn" onclick="toggleEdit(5)">
                                                                    <i class="ri-pencil-line"></i>
                                                                    <span class="ms-1">Edit</span>
                                                                </a>
                                                                <form action="https://rmrl.goliveapps.com/group/comments/delete/5" method="POST">
                                                                    <input type="hidden" name="_token" value="kfuSwMDld53jwjqUv83qmv1jMWo7wx0LC08ydASM">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="comment_delete_btn">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                        <span class="ms-1">Delete
                                                                            comment</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <!-- Edit comment form -->
                                                        <div class="d-none editCommentArea" data-comment-id="5">
                                                            <form action="https://rmrl.goliveapps.com/group/comments/edit/5" method="POST">
                                                                <input type="hidden" name="_token" value="kfuSwMDld53jwjqUv83qmv1jMWo7wx0LC08ydASM">
                                                                <input type="hidden" name="group_id" value="1">
                                                                <textarea name="comment" placeholder="Edit comment ..." class="editTextarea d-block my-3">Nice</textarea>
                                                                <button type="submit" class="editCommentBtn ps-btn ps-button-cancel">Edit
                                                                    Comment</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="wall-cmt-2" class="ps-comments ps-comments--nested ps-comment-nested">

                                                    <form action="https://rmrl.goliveapps.com/group/comments/reply/5" class="w-100" method="post">
                                                        <input type="hidden" name="_token" value="kfuSwMDld53jwjqUv83qmv1jMWo7wx0LC08ydASM">
                                                        <div class="ps-comments__reply ps-comment-reply cstream-form stream-form wallform ps-js-comment-new">
                                                            <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
                                                                <div class="ps-postbox__input-tag">
                                                                    <textarea data-act-id="3" class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a reply..." style="height: 40px;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="ps-comments__reply-send ps-comment-send cstream-form-submit">
                                                                <div class="ps-comments__reply-actions ps-comment-actions">
                                                                    <!--<button-->
                                                                    <!--    class="ps-btn ps-button-cancel">Clear</button>-->
                                                                    <!--<input type="hidden"-->
                                                                    <!--    name="type"-->
                                                                    <!--    value="reply"-->
                                                                    <!--    class="form-control">-->
                                                                    <button class="ps-btn ps-btn--action ps-button-action" type="submit">Post</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                            @endforeach

                                            <!-- WRITE COMMENT AREA -->
                                            <!--<div class="modal-footer d-flex justify-content-between">-->
                                            <div class="">
                                                <!-- Likes -->
                                                <div class="ps-comment__meta">
                                                    <div class="ps-comment__info">
                                                        <span class="activity-post-age activity-post-age-link">
                                                            <a href="#">
                                                                <span class="ps-js-autotime">18
                                                                    minutes ago</span>
                                                            </a>
                                                        </span>
                                                    </div>

                                                    <!-- Like count for comments -->
                                                    <div class="ps-comment__actions">
                                                        <div>
                                                            <a href="#" class="ps-comment__action ps-comment__action--like actaction-like" data-comment-id="5" data-item-type="comment">
                                                                <i class="ri-thumb-up-line"></i><span class="ms-1 like-text">Like</span>
                                                                <span>
                                                                    Liked by <span class="like-count">0</span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <a href="#reply" class="ps-comment__action ps-comment__action--reply actaction-reply ps-js-btn-reply">
                                                            <i class="gcir gci-comment-dots"></i><span>Reply</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <form action="{{ route('dashboard.group.post.comment', ['id' => $group_post->id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="group_id" value="{{ $group_post->id }}">
                                                    <div id="act-new-comment-{{ $group_post->id }}" class="ps-comments__reply cstream-form stream-form wallform ps-js-comment-new ps-js-newcomment-1">
                                                        <a class="ps-avatar cstream-avatar cstream-author me-2" href="#">
                                                            <a href="#" class="repliesAvatar">
                                                                <span style="color: goldenrod; font-size: 24px;">
                                                                    {{-- {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }} --}}
                                                                </span>
                                                            </a>
                                                        </a>
                                                        <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input me-2">
                                                            <div class="ps-postbox__input-tag">
                                                                <textarea class="ps-comments__input ps-textarea cstream-form-text ps-tagging-textarea" name="comment" placeholder="Write a comment..." style="height: 42px;" id="postTextArea{{ $group_post->id }}"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="ps-comments__reply-send cstream-form-submit">
                                                            <div class="ps-comments__reply-actions ps-comment-actions">
                                                                <!--<button class="ps-btn ps-button-cancel"-->
                                                                <!--    onclick="clearTextArea('postTextArea{{ $group_post->id }}')"-->
                                                                <!--    type="button">Clear</button>-->
                                                                <button class="ps-btn ps-btn--action ps-btn-primary ps-button-action" type="submit">Post</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="btn btn-default btn-prev">&lt;
                                    </button>
                                    <button type="button" class="btn btn-default btn-next">
                                        &gt;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="posts_filters posts_filters-compact-mobile pb-5">
    <div class="container">
        <div class="posts_filters-group posts_filters-group-primary">
            <div class="posts_filter posts_filter-myposts posts-dropdown posts-activitystream-filter">
                <a class="btn dropdown-toggle posts_filter-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-user-add-fill"></i>
                    <span class="ms-2">Show my posts</span>
                </a>
                <div class="dropdown-menu posts_filter-box posts_filter-box-myposts posts-dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="posts_filter-select">
                        <div class="ps-checkbox">
                            <input type="radio" name="stream_filter_show_my_posts" id="stream_filter_show_my_posts_opt_show_mine" value="show_mine" checked="">
                            <label for="stream_filter_show_my_posts_opt_show_mine">
                                <span>Show my posts</span>
                            </label>
                            <i class="ri-user-add-fill me-2"></i>
                        </div>
                    </a>
                    <a class="posts_filter-select">
                        <div class="ps-checkbox">
                            <input type="radio" name="stream_filter_show_my_posts" id="stream_filter_show_my_posts_opt_hide_mine" value="hide_mine">
                            <label for="stream_filter_show_my_posts_opt_hide_mine">
                                <span>Hide my posts</span>
                            </label>
                            <i class="ri-user-unfollow-fill me-2"></i>
                        </div>
                    </a>
                    <div class="posts_filter-actions">
                        <button class="posts_filter-action posts-btn ps-cancel btn btn-light">Cancel</button>
                        <button class="posts_filter-action posts-btn posts-btn-action posts-apply btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
            <div class="pposts_filter posts_filter-myposts posts-dropdown posts-activitystream-filter">
                <a class="btn dropdown-toggle posts_filter-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-chat-3-line"></i>
                    <span class="ms-2">New posts</span>
                </a>
                <div class="dropdown-menu posts_filter-box posts_filter-box-myposts posts-dropdown-menu" aria-labelledby="dropdownMenuLink2">
                    <a class="posts_filter-select">
                        <div class="ps-checkbox">
                            <input type="radio" name="stream_filter_sort_by" id="stream_filter_sort_by_opt_new" value="new" checked="">
                            <label for="stream_filter_sort_by_opt_new">
                                <span>New posts</span>
                            </label>
                            <i class="ri-user-forbid-fill"></i>
                        </div>
                    </a>
                    <a class="posts_filter-select">
                        <div class="ps-checkbox">
                            <input type="radio" name="stream_filter_sort_by" id="stream_filter_sort_by_opt_new_and_commented" value="new_and_commented">
                            <label for="stream_filter_sort_by_opt_new_and_commented">
                                <span>New posts &amp; comments</span>
                            </label>
                            <i class="gcis gci-comments ps-js-icon"></i>
                        </div>
                    </a>
                    <div class="posts_filter-actions">
                        <button class="posts_filter-action posts-btn ps-cancel btn btn-light">Cancel</button>
                        <button class="posts_filter-action posts-btn posts-btn-action posts-apply btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="posts_filters-group posts_filters-group-secondary">
        </div>
    </div>
</section>

<script>
    // Get all elements with class clickableElement
    var clickableElements = document.querySelectorAll('.clickableElement');

    // Add a click event listener to each clickable element
    clickableElements.forEach(function(element) {
        element.addEventListener('click', function() {
            // Get the value of the data-option-value attribute
            var optionValue = element.getAttribute('data-option-value');

            // Hide all elements with class tab-content
            document.querySelectorAll('.postbox_view').forEach(function(tab) {
                tab.style.display = 'none';
            });

            // Show the element with the corresponding data-tab-id
            var tabElement = document.querySelector('[data-tab-id="' + optionValue + '"]');
            if (tabElement) {
                tabElement.style.display = 'block';
            }
        });
    });

    $('.avatar-area, .post_type_menu-item-link').on('click', function() {
        var dropdownId = $(this).data('dropdown');
        $('#' + dropdownId).toggleClass('active');
    });

    function checkTextArea() {
        const textAreaValue = document.getElementById('text_post').value.trim();
        const postButton = document.getElementById('submitButton');
        if (textAreaValue === '') {
            postButton.classList.add('d-none');
        } else {
            postButton.classList.remove('d-none');
        }
    }

    function selectOption(option) {
        // Hide all forms by default
        var textPost = document.getElementById("textPost");

        var media = document.getElementById("mediaInputBox");
        var mediaFormDiv = document.getElementById("mediaFormDiv");

        var category = document.getElementById("categoryForm");
        var creatCategoryFormDiv = document.getElementById("creatCategoryFormDiv");

        var file = document.getElementById("fileForm");
        var uploadFileFormDiv = document.getElementById("uploadFileFormDiv");

        var gif = document.getElementById("gif");
        var gifSelectionFormDiv = document.getElementById("gifSelectionFormDiv");

        // Hide all forms and buttons
        textPost.classList.add("d-none");
        // group.classList.add("d-none");
        category.classList.add("d-none");
        // poll.classList.add("d-none");
        file.classList.add("d-none");
        gif.classList.add("d-none");

        // Show the selected form
        if (option === "text_post") {
            textPost.classList.remove("d-none");
            blogFormDiv.classList.remove("d-none");
            mediaFormDiv.classList.add("d-none");
            // createGroupFormDiv.classList.add("d-none");
            creatCategoryFormDiv.classList.add("d-none");
            // actualPollFormDiv.classList.add("d-none");
            uploadFileFormDiv.classList.add("d-none");
            gifSelectionFormDiv.classList.add("d-none");
        } else if (option === "media") {
            textPost.classList.add("d-none");
            blogFormDiv.classList.add("d-none");
            media.classList.remove("d-none");
            mediaFormDiv.classList.remove("d-none");
            // createGroupFormDiv.classList.add("d-none");
            creatCategoryFormDiv.classList.add("d-none");
            // actualPollFormDiv.classList.add("d-none");
            uploadFileFormDiv.classList.add("d-none");
            gifSelectionFormDiv.classList.add("d-none");
        } else if (option === "category") {
            category.classList.remove('d-none');
            textPost.classList.add("d-none");
            blogFormDiv.classList.add("d-none");
            mediaFormDiv.classList.add("d-none");
            // createGroupFormDiv.classList.add("d-none");
            creatCategoryFormDiv.classList.remove("d-none");
            // actualPollFormDiv.classList.add("d-none");
            uploadFileFormDiv.classList.add("d-none");
            gifSelectionFormDiv.classList.add("d-none");
        } else if (option === "file") {
            file.classList.remove('d-none');
            textPost.classList.add("d-none");
            blogFormDiv.classList.add("d-none");
            mediaFormDiv.classList.add("d-none");
            // createGroupFormDiv.classList.add("d-none");
            creatCategoryFormDiv.classList.add("d-none");
            // actualPollFormDiv.classList.add("d-none");
            uploadFileFormDiv.classList.remove("d-none");
            gifSelectionFormDiv.classList.add("d-none");
        } else if (option === "gif") {
            gif.classList.remove('d-none');
            textPost.classList.add("d-none");
            blogFormDiv.classList.add("d-none");
            mediaFormDiv.classList.add("d-none");
            // createGroupFormDiv.classList.add("d-none");
            creatCategoryFormDiv.classList.add("d-none");
            // actualPollFormDiv.classList.add("d-none");
            uploadFileFormDiv.classList.add("d-none");
            gifSelectionFormDiv.classList.remove("d-none");
        }

    }

    function submitForm(formId) {
        document.getElementById(formId).submit();
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

    function toggleReplyForm(commentId) {
        var x = document.getElementById("replyForm" + commentId);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function clearTextArea(textAreaId) {
        event.preventDefault();
        var textArea = document.getElementById(textAreaId);
        if (textArea) {
            textArea.value = '';
        }
    }

    function toggleEdit(commentId) {
        event.preventDefault();

        // Show or hide the specific editCommentArea for the clicked comment
        var specificEditCommentArea = document.querySelector('.editCommentArea[data-comment-id="' + commentId + '"]');
        if (specificEditCommentArea) {
            if (specificEditCommentArea.classList.contains('d-none')) {
                // If it's currently hidden, show it
                specificEditCommentArea.classList.remove('d-none');
            } else {
                // If it's currently visible, hide it
                specificEditCommentArea.classList.add('d-none');
            }

            // Hide all other editCommentArea elements
            var editCommentAreas = document.querySelectorAll('.editCommentArea:not([data-comment-id="' + commentId +
                '"])');
            editCommentAreas.forEach(function(area) {
                area.classList.add('d-none');
            });
        }
    }

    function toggleEditReply(replyId) {
        event.preventDefault();
        // Show or hide the specific editReplyArea for the clicked reply
        var specificEditReplyArea = document.querySelector('.editReplyArea[data-reply-id="' + replyId + '"]');
        if (specificEditReplyArea) {
            if (specificEditReplyArea.classList.contains('d-none')) {
                // If it's currently hidden, show it
                specificEditReplyArea.classList.remove('d-none');
            } else {
                // If it's currently visible, hide it
                specificEditReplyArea.classList.add('d-none');
            }

            // Hide all other editReplyArea elements
            var editReplyAreas = document.querySelectorAll('.editReplyArea:not([data-reply-id="' + replyId + '"])');
            editReplyAreas.forEach(function(area) {
                area.classList.add('d-none');
            });
        }
    }

    // Toggling like/unlike for comments with count
    $(document).ready(async function() {
        // Event handler for comments
        $('.actaction-like').on('click', async function(e) {
            e.preventDefault();
            var itemId = $(this).data('comment-id');
            var itemType = 'comment'; // Set the item type for comments
            var likeButton = $(this);

            // AJAX function for liking and disliking
            try {
                var response = await $.ajax({
                    url: "/group-comment-like/" + itemId,
                    type: "GET",
                });

                if (response && response.indexOf('success') !== -1 && response.indexOf(
                        'true') !== -1) {
                    toggleLikeButton(likeButton);
                    updateLikeCount(itemId, itemType);
                } else {
                    console.log('Error: Unable to process the response.');
                }
            } catch (error) {
                console.error('AJAX Error:', error);
            }
        });

        // Event handler for replies
        $('.actaction-like-reply').on('click', async function(e) {
            e.preventDefault();
            var itemId = $(this).data('reply-id');
            var itemType = 'reply'; // Set the item type for replies
            var likeButton = $(this);

            // AJAX function for liking and disliking
            try {
                var response = await $.ajax({
                    url: "/group-comment-like/" + itemId,
                    type: "GET",
                });

                if (response && response.indexOf('success') !== -1 && response.indexOf(
                        'true') !== -1) {
                    toggleLikeButton(likeButton);
                    updateLikeCount(itemId, itemType);
                } else {
                    console.log('Error: Unable to process the response.');
                }
            } catch (error) {
                console.error('AJAX Error:', error);
            }
        });

        // Initialize like counts on page load
        $('.actaction-like').each(async function() {
            var itemId = $(this).data('comment-id');
            var itemType = 'comment';
            await updateLikeCount(itemId, itemType);
        });

        $('.actaction-like-reply').each(async function() {
            var itemId = $(this).data('reply-id');
            var itemType = 'reply';
            await updateLikeCount(itemId, itemType);
        });
    });

    function toggleLikeButton(likeButton) {
        var buttonText = likeButton.find('.like-text').text() === 'Liked' ? 'Like' : 'Liked';
        likeButton.find('.like-text').text(buttonText);

        var iconClass = likeButton.find('i').hasClass('ri-thumb-up-fill') ? 'ri-thumb-up-line' : 'ri-thumb-up-fill';
        likeButton.find('i').removeClass().addClass('ri ' + iconClass);
    }

    async function updateLikeCount(itemId, itemType) {
        try {
            var response = await $.ajax({
                url: '/group-comment-like-count/' + itemId,
                type: 'GET',
                dataType: 'json',
            });

            var likeCount = response.likeCount;
            // Update the like count on the page for the specific comment or reply
            if (itemType === 'comment') {
                $('.actaction-like[data-comment-id="' + itemId + '"] .like-count').text(likeCount);
            } else if (itemType === 'reply') {
                // Update the like count for replies and keep the "Liked by" text constant
                $('.actaction-like-reply[data-reply-id="' + itemId + '"] .reply-like-count').html(
                    'Liked by <span class="like-count">' + likeCount + '</span>');
            }
        } catch (error) {
            console.error('Error fetching like count:', error);
        }
    }

    $(document).ready(async function() {
        $('.group-post-like').on('click', async function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var likeButton = $(this);

            try {
                // Toggle like
                await toggleLike(postId);

                // Update like count on like toggle
                await updateLikeAndToggle(postId, likeButton);
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        });
        await showLikeCountOnLoad();
        async function toggleLike(postId) {
            try {
                await $.ajax({
                    type: 'GET',
                    url: '/likeGroupPosts/' + postId
                });
                console.log('Like toggled successfully');
            } catch (error) {
                throw new Error('Error toggling like:', error);
            }
        }
        async function showLikeCountOnLoad() {
            var postId = $('.group-post-like').data('post-id');
            try {
                var response = await $.ajax({
                    type: 'GET',
                    url: '/liked-group-post-count/' + postId
                });

                var likeButton = $('.group-post-like');
                var buttonText = likeButton.find('.custom-like-text').text().includes('Liked') ?
                    'Liked by' + ' ' + response.likesCount : 'Liked by' + ' ' + response.likesCount;
                likeButton.find('.custom-like-text').text(buttonText);
            } catch (error) {
                console.error('Error updating like count:', error);
            }
        }
        async function updateLikeAndToggle(postId, likeButton) {
            try {
                var response = await $.ajax({
                    type: 'GET',
                    url: '/liked-group-post-count/' + postId
                });

                var buttonText = likeButton.find('.custom-like-text').text().includes('Liked') ?
                    'Liked by' + ' ' + response.likesCount : 'Liked by' + ' ' + response.likesCount;
                likeButton.find('.custom-like-text').text(buttonText);

                var iconClass = likeButton.find('i').hasClass('ri-thumb-up-fill') ?
                    'ri-thumb-up-line' : 'ri-thumb-up-fill';
                likeButton.find('i').removeClass().addClass('ri ' + iconClass);
            } catch (error) {
                console.error('Error updating like count:', error);
            }
        }
    });

    $(document).ready(async function() {
        $('.group-media-like').on('click', async function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var likeButton = $(this);
            try {
                // Toggle like
                await toggleLike(postId);
                // Update like count on like toggle
                await updateLikeAndToggle(postId, likeButton);
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        });
        await showLikeCountOnLoad();
        async function toggleLike(postId) {
            try {
                await $.ajax({
                    type: 'GET',
                    url: '/likeGroupMedia/' + postId
                });
                console.log('Like toggled successfully');
            } catch (error) {
                throw new Error('Error toggling like:', error);
            }
        }


        async function showLikeCountOnLoad() {
            var postId = $('.group-media-like').data('post-id');
            try {
                var response = await $.ajax({
                    type: 'GET',
                    url: '/liked-group-media-count/' + postId
                });

                var likeButton = $('.group-media-like');
                var buttonText = likeButton.find('.custom-like-text').text().includes('Liked') ?
                    'Liked by' + ' ' + response.likesCount : 'Liked by' + ' ' + response.likesCount;
                likeButton.find('.custom-like-text').text(buttonText);
                console.log(response);
            } catch (error) {
                console.error('Error updating like count:', error);
            }
        }
        async function updateLikeAndToggle(postId, likeButton) {
            try {
                var response = await $.ajax({
                    type: 'GET',
                    url: '/liked-group-media-count/' + postId
                });

                var buttonText = likeButton.find('.custom-like-text').text().includes('Liked') ?
                    'Liked by' + ' ' + response.likesCount : 'Liked by' + ' ' + response.likesCount;
                likeButton.find('.custom-like-text').text(buttonText);

                var iconClass = likeButton.find('i').hasClass('ri-thumb-up-fill') ?
                    'ri-thumb-up-line' : 'ri-thumb-up-fill';
                likeButton.find('i').removeClass().addClass('ri ' + iconClass);
            } catch (error) {
                console.error('Error updating like count:', error);
            }
        }
    });

    function stopPropagation(event) {
        event.stopPropagation();
    }

    function initiateFileInput() {
        document.getElementById('files').click();
    }
</script>

<script>
    $(document).ready(function() {
        // Event listener for clicking on an image
        $('.lightbox-trigger').click(function() {
            var imageUrl = $(this).attr('src');
            $('#lightboxImage').attr('src', imageUrl);
            $('#imageModal').modal('show');

            // Store the current image index in the modal data
            $('#imageModal').data('current-index', $(this).data('index'));
        });

        // Event listener for navigating to the previous image
        $('#imageModal').on('click', '.btn-prev', function() {
            navigateImage(-1);
        });

        // Event listener for navigating to the next image
        $('#imageModal').on('click', '.btn-next', function() {
            navigateImage(1);
        });

        // Function to navigate to the previous or next image
        function navigateImage(offset) {
            var currentIndex = $('#imageModal').data('current-index');
            var newIndex = (currentIndex + offset + $('.lightbox-trigger').length) % $('.lightbox-trigger')
                .length;

            var newImageUrl = $('.lightbox-trigger[data-index="' + newIndex + '"]').attr('src');
            $('#lightboxImage').attr('src', newImageUrl);
            $('#imageModal').data('current-index', newIndex);
        }
    });
</script>
@endsection