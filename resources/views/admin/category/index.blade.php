@extends('layouts.dashboard')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container w-100 mb-5">
                <nav aria-label="breadcrumb" class="my-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
                {{-- modal form --}}
                <div class="my-4">
                    <button type="button" class="ps-btn postbox-submit" data-bs-toggle="modal"
                        data-bs-target="#categoryFormModal">
                        Create Album
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="categoryFormModal" tabindex="-1" aria-labelledby="categoryFormModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="categoryFormModalLabel">Create Group</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('dashboard.storeCategory') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="album_name" class="form-label">Album name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="album_name" id="album_name">
                                            @error('album_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="album_description" class="form-label"> Description</label>
                                            <input type="text" class="form-control" name="album_description"
                                                id="album_description">
                                            @error('album_description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="files">Upload media to album</label>
                                            <input type="file" name="files[]" id="files" class="form-control"
                                                accept="image/*,video/*" multiple>
                                            @error('files')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
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
                </div>
                {{-- Display all pictures --}}
                <div>
                    <h2>
                        @if ($option === 'photos')
                            Latest Photos
                        @elseif ($option === 'albums')
                            Photos by Albums
                        @endif
                    </h2>
                    <!-- Buttons to select the display option -->
                    <div class="ms-2 my-4">
                        <form method="GET" action="{{ route('dashboard.category') }}">
                            <input type="hidden" name="option" value="{{ $option }}">
                            <button class="ps-btn postbox-submit" type="submit" name="option"
                                value="photos">Photos</button>
                            <button class="ps-btn postbox-submit" type="submit" name="option"
                                value="albums">Albums</button>
                        </form>
                    </div>
                    @if ($option === 'photos')
                        <!-- Display images based on the selected option (latest photos) -->
                        @foreach ($media as $image)
                            <!-- Display image here -->
                            <img src="{{ $image->file_path }}" alt="Image" width="320" height="250"
                                class="rounded p-1">
                        @endforeach
                    @elseif ($option === 'albums')
                        @if (count($latestImages) > 0)
                            <div class="container">
                                <div class="row">
                                    @foreach ($latestImages as $category_id => $latestImage)
                                        @if ($latestImage)
                                            <!-- Check if $latestImage is not null -->
                                            <div class="col-md-4 mb-4">
                                                <div class="card">
                                                    <a
                                                        href="{{ route('dashboard.category.images', ['category_id' => $category_id]) }}">
                                                        <img src="{{ $latestImage->file_path }}" alt="Latest Image"
                                                            class="card-img-top" width="400" height="250"
                                                            data-category="{{ $category_id }}">
                                                    </a>
                                                    <div class="">
                                                        <h5 class="ms-2">
                                                            {{ $latestImage->category->album_name }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Display Stream Post collection -->
                            @if (!empty($streamPostMedia))
                                <div class="container mt-4">
                                    <h2>Stream Post</h2>
                                    <div class="row">
                                        @foreach ($streamPostMedia as $streamMedia)
                                            <div class="col-md-4 mb-4">
                                                <div class="card">
                                                    <img src="{{ $streamMedia->file_path }}" alt="Stream Post Image"
                                                        class="card-img-top" width="400" height="250">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                There are no images in any albums. You can create albums and add images to them.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if ($errors->any())
                $('#categoryFormModal').modal('show');
            @endif
        });
    </script>
@endsection
