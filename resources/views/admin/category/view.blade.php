@extends('layouts.dashboard')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" class="my-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
                <div>
                    <h1>{{ $category->album_name }}</h1>
                    <div class="image-container">
                        @foreach ($categoryImages as $image)
                            <img src="{{ $image->file_path }}" alt="Image" width="400" height="250" class="rounded p-1">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
