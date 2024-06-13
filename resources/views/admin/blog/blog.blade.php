@extends('layouts.dashboard')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="dispplay-1 text-center">
                        Get Ready to Share Your Awesome Story!
                    </h1>
                    <a href="{{ route('admin.blog.view') }}">View all the blogs</a>
                </div>
            </div>

            <div class="col-12">
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

            <div class="col-12">
                <form action="{{ route('admin.blog.post') }}" class="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Blog Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Share your idea...">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Blog Post</label>
                        <textarea class="form-control" id="content" rows="5" name="content"
                            placeholder="Enter your inspiring blog content here..."></textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-4 mb-5 m-auto">
                        <input type="submit" value="Post your blog" class="btn btn-primary w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
