@extends('layouts.dashboard')

@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row">
            <h2>Searched Result</h2>
            @if (count($blogs) > 0)
                @foreach ($blogs as $blog)
                    <div class="col-12">
                        <div class="card my-5">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('admin.blog.detail', ['id' => $blog->id]) }}">{{ $blog->title }}</a>
                                </h5>
                                <p class="card-text">
                                    {{ substr($blog->content, 0, 190) . (strlen($blog->content) > 190 ? '...' : '') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No blogs found.</p>
            @endif
        </div>
    </div>
@endsection
