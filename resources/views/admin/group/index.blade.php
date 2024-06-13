@extends('layouts.dashboard')

@section('content')
    <style>
        .read-more-btn {
            margin: 0px 0px 0px -62px;
        }

        .details-btns {
            border: lightgray 1px solid;
            width: 100%;
            padding: 10px 0px 10px 0px;
            background-color: white;
        }

        .list-group-item {
            padding: 16px 0px 0px 0px;
        }

        .circular-image {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }

        .group_picture {
            margin: -50px 0px 20px 20px;
        }

        .card-img-top {
            height: 450px;
        }

        .default-cover-image {
            height: 280px;
        }
    </style>

    <div class="content-page">
        <div class="content">
            <div class="container w-100">

                <div class="mt-4">
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

                <button type="button" class="ps-btn postbox-submit p-3 m-5" data-bs-toggle="modal"
                    data-bs-target="#groupFormModal">
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
                            <form action="{{ route('dashboard.createGroup') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="group_name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="group_name" id="group_name"
                                            placeholder="Enter your group's name...">
                                        @error('group_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="group_description" class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="group_description"
                                            id="group_description" placeholder="Enter your group's description...">
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

                                    <div class="mb-3 row">
                                        <div class="col-6">
                                            <label class="form-label" for="group_photo">Group Photo</label>
                                            <input type="file" class="form-control" name="group_photo" id="group_photo">
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label" for="group_cover_image">Group Cover Photo</label>
                                            <input type="file" class="form-control" name="group_cover_image"
                                                id="group_cover_image">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="ps-btn postbox-submit"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="ps-btn postbox-submit">Create Group</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Display all the groups -->
                <div class="my-3 mx-5">
                    <div class="row">
                        @foreach ($groups as $group)
                            <div class="col-6">
                                <div class="card mb-3">
                                    <div class="cover-image-container">
                                        <!-- Rectangular Cover Image -->
                                        @if (auth()->user()->role_id == 3)
                                            <a href="{{ route('dashboard.group.view', ['id' => $group->id]) }}">
                                                @if ($group->group_cover_image)
                                                    <img src="{{ $group->group_cover_image }}" class="card-img-top"
                                                        alt="Original Image">
                                                @else
                                                    <img src="{{ asset('assets/images/default-cover-img.png') }}"
                                                        class="card-img-top default-cover-image" alt="Original Image">
                                                @endif
                                            </a>
                                        @else
                                            @if ($group->privacy_type == 'Open')
                                                <a href="{{ route('dashboard.group.view', ['id' => $group->id]) }}">
                                                    @if ($group->group_cover_image)
                                                        <img src="{{ $group->group_cover_image }}" class="card-img-top"
                                                            alt="Original Image">
                                                    @else
                                                        <img src="{{ asset('assets/images/default-cover-img.png') }}"
                                                            class="card-img-top default-cover-image" alt="Original Image">
                                                    @endif
                                                </a>
                                            @elseif ($group->privacy_type == 'Private')
                                                @php
                                                    $userIsMember = $group->userGroups
                                                        ->where('user_id', auth()->id())
                                                        ->where('accepted', 1)
                                                        ->isNotEmpty();
                                                @endphp

                                                @if ($userIsMember)
                                                    <a href="{{ route('dashboard.group.view', ['id' => $group->id]) }}">
                                                        @if ($group->group_cover_image)
                                                            <img src="{{ $group->group_cover_image }}"
                                                                class="card-img-top" alt="Original Image">
                                                        @else
                                                            <img src="{{ asset('assets/images/default-cover-img.png') }}"
                                                                class="card-img-top default-cover-image"
                                                                alt="Original Image">
                                                        @endif
                                                    </a>
                                                @else
                                                    @if ($group->group_cover_image)
                                                        <img src="{{ $group->group_cover_image }}" class="card-img-top"
                                                            alt="Original Image">
                                                    @else
                                                        <img src="{{ asset('assets/images/default-cover-img.png') }}"
                                                            class="card-img-top default-cover-image" alt="Original Image">
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        <!-- Circular Image -->
                                        <div class="group_picture">
                                            @if ($group->group_photo)
                                                <img src="{{ $group->group_photo }}" class="circular-image"
                                                    alt="Circular Image">
                                            @else
                                                <img src="{{ asset('assets/images/default-group-photo.png') }}"
                                                    class="circular-image" alt="Circular Image">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        @if (auth()->user()->role_id == 3)
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('dashboard.group.view', ['id' => $group->id]) }}">
                                                    <h5 class="card-title mx-4">{{ $group->group_name }}</h5>
                                                </a>
                                                <h5 class="card-title mx-4">{{ $group->privacy_type }}</h5>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-between mx-4">
                                                @if ($group->privacy_type == 'Open')
                                                    <a href="{{ route('dashboard.group.view', ['id' => $group->id]) }}">
                                                        <h5 class="card-title mx-4">{{ $group->group_name }}</h5>
                                                    </a>
                                                @elseif ($group->privacy_type == 'Secret')
                                                    <!-- Do not display anything for Secret groups for users with role_id 1 -->
                                                @elseif ($group->privacy_type == 'Private')
                                                    @if ($user_group->isNotEmpty() && $user_group->first()->accepted == 1 && $user_group->first()->rejected == 0)
                                                        <a
                                                            href="{{ route('dashboard.group.view', ['id' => $group->id]) }}">
                                                            <h5 class="card-title mx-4">{{ $group->group_name }}</h5>
                                                        </a>
                                                    @else
                                                        <h5 class="card-title mx-4">{{ $group->group_name }}</h5>
                                                    @endif
                                                @endif
                                                <h5 class="card-title mx-4">{{ $group->privacy_type }}</h5>
                                            </div>
                                        @endif
                                        <p class="card-text mx-4">{{ $group->group_description }}</p>
                                        <!-- Initially hidden, can be toggled -->
                                        <div class="toggle_data d-none">
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    {{ $group->created_at->format('F j, Y') }}
                                                </small>
                                            </p>

                                            <p class="card-text mx-4">
                                                <small class="text-muted">
                                                    Owner:
                                                    {{ \App\Enums\UserTypes::LIST[$group->user->role_id] ?? 'Unknown' }}
                                                </small>
                                            </p>
                                        </div>

                                        <p class="card-text read-more-btn">
                                            <button class="btn btn-link toggle-button text-decoration-none">
                                                <span class="icon-container"></span>
                                                <span class="toggle-text"> <i class="ri-error-warning-line"></i>
                                                    more</span>
                                            </button>
                                        </p>

                                        <!-- Show owners using data from controller -->
                                        <div class="d-flex justify-content-between">
                                            <ul class="list-group list-group-flush text-center w-100">
                                                <li class="list-group-item">
                                                    @if ($group->user_id == auth()->user()->id)
                                                        <button class="details-btns show_details">
                                                            Owner
                                                        </button>
                                                    @elseif ($group->privacy_type != 'Open' && $user_group->isEmpty() && auth()->user()->role_id == 1)
                                                        <button class="details-btns show_details">
                                                            Apply
                                                        </button>
                                                    @endif
                                                </li>
                                            </ul>

                                            @if ($group->user_id == auth()->user()->id)
                                                <ul class="list-group list-group-flush text-center w-100">
                                                    <li class="list-group-item">
                                                        <button class="details-btns actions_btn">
                                                            <i class="ri-checkbox-fill"></i>
                                                            <i class="ri-notification-3-line"></i>
                                                        </button>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>

                                        <!-- Check if logged-in user is the owner -->
                                        <div class="col-12 details_box d-none mx-2 mt-2">
                                            @if ($group->user_id == auth()->user()->id)
                                                <div class="mx-2">
                                                    <strong>You are the group owner</strong>
                                                </div>
                                                <div class="card-text text-muted my-2 mx-2">
                                                    As an owner, you can manage all aspects of the group and its content.
                                                </div>
                                                <div class="card-text text-muted my-4 mx-2">
                                                    You can't leave this group. To be able to leave, you need to transfer
                                                    ownership to another user first.
                                                </div>
                                            @elseif ($group->privacy_type != 'Open')
                                                <div class="text-center">
                                                    <form action="{{ route('group.apply') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $group->id }}">
                                                        <input type="submit" value="Apply to this group"
                                                            class="bg-white border-0 my-2">
                                                    </form>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="#" onclick="event.preventDefault()" class="my-following-link">
                                            <div class="col-12 actions_box d-none">
                                                <div class="mb-3 d-flex justify-content-between mx-2">
                                                    Follow
                                                    <input type="checkbox" name="my_following"
                                                        onclick="event.stopPropagation()">
                                                </div>
                                                <small class="text-muted mx-2">
                                                    Show posts from this group in "my following" stream
                                                </small>
                                                <hr>
                                            </div>
                                        </a>

                                        <a href="#" onclick="event.preventDefault()" class="my-following-link">
                                            <div class="col-12 actions_box d-none">
                                                <div class="mb-3 d-flex justify-content-between mx-2">
                                                    Be notified
                                                    <input type="checkbox" name="my_following"
                                                        onclick="event.stopPropagation()">
                                                </div>
                                                <small class="text-muted mx-2">
                                                    Be notified about new posts in this group
                                                </small>
                                                <hr>
                                            </div>
                                        </a>

                                        <a href="#" onclick="event.preventDefault()" class="my-following-link">
                                            <div class="col-12 actions_box d-none">
                                                <div class="mb-3 d-flex justify-content-between mx-2">
                                                    Receive emails
                                                    <input type="checkbox" name="my_following"
                                                        onclick="event.stopPropagation()">
                                                </div>
                                                <small class="text-muted mx-2">
                                                    Receive emails about new posts in this group
                                                </small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                $('#groupFormModal').modal('show');
            @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-button');

            toggleButtons.forEach(function(toggleButton) {
                toggleButton.addEventListener('click', function() {
                    const card = this.closest('.card');
                    const toggleData = card.querySelector('.toggle_data');
                    const iconContainer = this.querySelector('.icon-container');
                    const toggleText = this.querySelector('.toggle-text');

                    if (toggleData.classList.contains('d-none')) {
                        toggleData.classList.remove('d-none');
                        iconContainer.innerHTML = '<i class="ri-error-warning-line"></i>';
                        toggleText.textContent = 'less';
                    } else {
                        toggleData.classList.add('d-none');
                        iconContainer.innerHTML = '<i class="ri-error-warning-line"></i>';
                        toggleText.textContent = 'more';
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.show_details').on('click', function() {
                var card = $(this).closest('.card');
                card.find('.actions_box').addClass('d-none');
                card.find('.details_box').toggleClass('d-none');
            });

            $('.actions_btn').on('click', function() {
                var card = $(this).closest('.card');
                card.find('.details_box').addClass('d-none');
                card.find('.actions_box').toggleClass('d-none');
            });
        });

        $(document).ready(function() {
            $('.my-following-link').on('click', function(event) {
                event.preventDefault();
                var checkbox = $(this).find('input[type="checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));
            });
        });
    </script>
@endsection
