@extends('layouts.dashboard')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col">

                {{-- @dump($blog) --}}
                <div class="card col-12">
                    <div class="card-body">
                        <h5 class="card-title display-6">{{ $blog->title }}</h5>
                        <p class="card-text my-4">
                            {{ $blog->content }}
                        </p>
                        <a href="{{ route('admin.blog.view') }}" class="card-link">View all blogs</a>
                        <a href="{{ route('admin.blog') }}" class="card-link">Write your blog</a>

                        <span class=" float-end text-secondary fst-italic">
                            Published by: {{ $blog->user->first_name . ' ' . $blog->user->last_name }}
                        </span>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
