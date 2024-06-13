@extends('layouts.dashboard')

@section('content')
    @if (count($blogs) > 0)
        <div class="container my-5">
            <div class="row align-items-center mb-4">
                <div class="col-6">
                    <h1 class="display-1">
                        All Blogs
                    </h1>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.blog') }}">Share Your Story</a>
                </div>
            </div>

            <div class="row">
                @foreach ($blogs as $key => $blog)
                    <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6 mb-4">
                        <div class="card @if (!$loop->last) mr-md-3 @endif">
                            <div class="card-body">
                                <h3 class="card-title">{{ $blog->title }}</h3>
                                <p class="card-text">
                                    {{ substr($blog->content, 0, 100) . (strlen($blog->content) > 100 ? '...' : '') }}
                                </p>
                                <div class="mt-5 float-end fst-italic">
                                    <a href="{{ route('admin.blog.detail', ['id' => $blog->id]) }}">
                                        Read more...
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="container my-5">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="display-6 text-center text-secondary">
                        No blog posts found!
                    </h2>
                </div>
                <div class="col-auto">
                    <a class="ms-3" href="{{ route('admin.blog') }}">Share Your Story</a>
                </div>
            </div>
        </div>
    @endif
@endsection
