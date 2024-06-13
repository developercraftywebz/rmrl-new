    <style>
        .customDropDown {
            margin: 3.5rem 0rem 0rem 77rem;
        }

        /* Styles for the custom modal */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.3s;
        }

        .custom-modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            border-radius: 20px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .profile_img_box:hover {
            cursor: pointer;
        }

        .default_profile_img {
            background-color: #A7862A;
        }

        .fixed-height-image {
            height: 40rem;
        }
    </style>

    @php
        $segments = Request::segments();
        $requiredSegments = ['group'];
        $hasProfileSegment = count(array_intersect($requiredSegments, $segments)) > 0;
        $images = App\Models\AdminProfileImage::get();
    @endphp

    @if ($hasProfileSegment)
        <section class="cover-photo-section-a">
            <div class="container w-100">
                <div class="cover-box-a">
                    <div class="cover-img-area">
                        <div class="dropdown" id="myDropdown" style="display: none;">
                            <div class="dropdown-menu show customDropDown">
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#coverImgModal">
                                    Upload new
                                </button>
                                @if ($hasProfileSegment && count($images) > 0)
                                    @foreach ($images as $image)
                                        <a class="dropdown-item" href="#"
                                            onclick="showImagePreview('{{ $image->cover_image }}')">Image Preview</a>
                                    @endforeach
                                @endif
                                @foreach ($images as $image)
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $image->id }}').submit();">
                                        Delete
                                        <form id="delete-form-{{ $image->id }}"
                                            action="{{ route('upload.image.delete') }}" method="post"
                                            style="display: none;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $image->id }}">
                                            @if ($image->cover_image)
                                                <input type="hidden" name="cover_image"
                                                    value="{{ $image->cover_image }}">
                                            @endif
                                        </form>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Modal for Image Preview -->
                        <div class="modal" id="imagePreviewModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Image Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img id="previewImage" src="" class="img-fluid" alt="Image Preview">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cover image modal -->
                        <div class="modal fade" id="coverImgModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('upload.image') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div class="modal-body">
                                            @csrf
                                            <label class="dropdown-item">
                                                Upload new
                                                <input type="file" name="cover_image" class="form-control">
                                            </label>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary" value="Upload" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if ($hasProfileSegment && count($images) > 0)
                            @php
                                $latestCoverImage = $images->sortByDesc('created_at')->first();
                            @endphp
                            @if ($latestCoverImage && $latestCoverImage->cover_image)
                                <img src="{{ $latestCoverImage->cover_image }}" class="fixed-height-image"
                                    alt="User Cover Image">
                            @else
                                <img src="{{ asset('assets/images/dashboard/cover.webp') }}" class="img-fluid"
                                    alt="Default Cover Image">
                            @endif
                        @else
                            <img src="{{ asset('assets/images/dashboard/cover.webp') }}" class="img-fluid"
                                alt="Default Cover Image">
                        @endif

                    </div>
                    <a href="#!" class="cover-change-btn" onclick="toggleDropdown()">
                        Change Cover
                        <i class="ri-image-fill"></i>
                    </a>
                    {{-- <a href="#!" class="info-update-btn"><i class="ri-image-fill"></i> Update Info</a> --}}
                </div>

                <div class="profile-view-details">
                    <div class="profile-left-a">
                        @if (isset($image) && isset($image->profile_image))
                            <div class="profile-img-box profile_img_box"
                                onclick="openCustomModal('{{ $image->profile_image }}')">
                            @else
                                <div class="profile-img-box profile_img_box"
                                    onclick="openCustomModal('assets/images/users/default.jpeg')">
                        @endif
                        @if ($hasProfileSegment && count($images) > 0)
                            @php
                                $latestProfileImage = $images->sortByDesc('created_at')->first();
                            @endphp
                            @if ($latestProfileImage && $latestProfileImage->profile_image)
                                <img src="{{ $latestProfileImage->profile_image }}" class="img-fluid"
                                    alt="User Cover Image">
                            @else
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center default_profile_img"
                                        style="width: 150px; height: 150px;">
                                        <h1 class="display-1 text-white">
                                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                                        </h1>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                <div class="rounded-circle d-flex justify-content-center align-items-center default_profile_img"
                                    style="width: 150px; height: 150px;">
                                    <h1 class="display-1 text-white">
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                                    </h1>
                                </div>
                            </div>
                            {{-- <img src="{{ asset('assets/images/dashboard/profile-placeholder.svg') }}" class="img-fluid" alt=""> --}}
                        @endif
                    </div>
                </div>

                <!-- Custom Profile Image Modal -->
                <div class="custom-modal" id="customModal" style="display: none;">
                    <div class="custom-modal-content" style="position: relative; padding: 20px;">
                        <span class="close" style="position: absolute; top: 10px; right: 10px; cursor: pointer;"
                            onclick="closeCustomModal()">&times;</span>
                        <div style="text-align: center;">
                            <img id="profilePreviewImage" src="" alt="Profile Image Preview"
                                style="width: 350px; height: 350px; display: block; margin: 0 auto;">
                        </div>
                        <p style="text-align: center; margin-top: 20px;">Upload Profile Image</p>
                        <form action="{{ route('upload.image') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_image" class="form-control"
                                style="width: 100%; margin-bottom: 15px;">
                            <div class="text-center">
                                <input type="submit" value="Upload" class="btn btn-primary"
                                    style="margin-right: 10px;">
                                <button type="button" class="btn btn-secondary"
                                    onclick="closeCustomModal()">Close</button>
                            </div>
                        </form>
                        @foreach ($images as $image)
                            <div class="text-center mt-4">
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('delete-profile-form-{{ $image->id }}').submit();">
                                    Delete Profile Image
                                    <form id="delete-profile-form-{{ $image->id }}"
                                        action="{{ route('upload.image.delete') }}" method="post"
                                        style="display: none;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $image->id }}">
                                        @if ($image->profile_image)
                                            <input type="hidden" name="profile_image"
                                                value="{{ $image->profile_image }}">
                                        @endif
                                    </form>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="profile-right-a">
                    <div class="row-a">
                        <div class="inner-left-a">
                            <p class="p-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            <!--<ul class="list-a p-ul-a">-->
                            <!--    <li>-->
                            <!--        <a href="#!">-->
                            <!--            <i class="ri-user-add-fill"></i>-->
                            <!--            Member since March 24, 2022-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a href="#!">-->
                            <!--            <i class="ri-group-fill"></i>-->
                            <!--            1 Friend-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    {{-- @php-->
                            <!--    $id = request()->segment(3);-->
                            <!--    $group = App\Models\Group::findOrFail($id);-->
                            <!--    $memberCount = $group-->
                            <!--        ->userGroups()-->
                            <!--        ->where('accepted', 1)-->
                            <!--        ->count();-->
                            <!--@endphp-->
                            <!--<li>-->
                            <!--    <a href="#!">-->
                            <!--        <i class="ri-team-fill"></i>-->
                            <!--        {{ $memberCount }} members-->
                            <!--    </a>-->
                            <!--</li> --}}-->
                            <!--</ul>-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation links -->
            <div class="profile-other-links">
                <ul class="list-a profile-other-ul">
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="ri-home-5-fill"></i>
                            Stream
                        </a>
                    </li>
                    @php
                        $secretGroups = \App\Models\Group::where('privacy_type', 'Secret')->get();
                    @endphp

                    @if ($secretGroups->isNotEmpty())
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('invite.members', ['id' => $secretGroups->first()->id]) }}">
                                <i class="ri-user-received-2-line"></i>
                                Active Users
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item" href="{{ route('user.about') }}">
                                <i class="ri-account-circle-fill"></i>
                                About
                            </a>
                        </li>
                    @endif

                    {{-- <li>
                    <a class="dropdown-item" href="{{ route('admin.blog.view') }}">
                        <i class="ri-double-quotes-r"></i>
                        Blog
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#!">
                        <i class="ri-user-follow-fill"></i>
                        Followers
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#!">
                        <i class="ri-group-fill"></i>
                        Friends
                    </a>
                </li> --}}
                    <li><a class="dropdown-item" href="{{ route('dashboard.group') }}">
                            <i class="ri-group-2-fill"></i>
                            Groups</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard.category') }}">
                            <i class="ri-camera-switch-fill"></i> Photos /
                            <i class="ri-vidicon-line"></i> Videos
                        </a>
                    </li>
                    @php
                        $group = Request::segment(3);
                    @endphp
                    @if (auth()->check() && auth()->user()->role_id == \App\Enums\UserTypes::Admin)
                        <li>
                            <a href="{{ route('group.member.applicants', ['id' => $group]) }}"
                                class="dropdown-item">
                                <i class="ri-user-add-fill"></i>
                                Member Requests
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group.member', ['id' => $group]) }}"
                                class="dropdown-item">
                                <i class="ri-team-fill"></i>
                                Members
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group.member.rejected', ['id' => $group]) }}"
                                class="dropdown-item">
                                <i class="ri-user-unfollow-fill"></i>
                                Blocked Members
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('subscriptions.index') }}">
                                <i class="ri-profile-fill"></i>
                                Membership
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item" href="{{ route('plans.index') }}">
                                <i class="ri-profile-fill"></i>
                                Membership
                            </a>
                        </li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="ri-logout-circle-r-line"></i>
                                Log Out
                            </a>
                            <button class="btn btn-primary d-none" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </section>

        <script>
            function toggleDropdown() {
                var dropdown = document.getElementById("myDropdown");
                if (dropdown.style.display === "none") {
                    dropdown.style.display = "block";
                } else {
                    dropdown.style.display = "none";
                }
            }

            function openCustomModal(imageSrc) {
                var modal = document.getElementById('customModal');
                var image = document.getElementById('profilePreviewImage');
                if (imageSrc) {
                    image.src = imageSrc;
                }
                modal.style.display = 'block';
            }

            function closeCustomModal() {
                var modal = document.getElementById('customModal');
                modal.style.display = 'none';
            }

            function showImagePreview(imageSrc) {
                var previewModal = document.getElementById('imagePreviewModal');
                var previewImage = document.getElementById('previewImage');
                previewImage.src = imageSrc;
                var myModal = new bootstrap.Modal(previewModal);
                myModal.show();
            }
        </script>
    @endif
