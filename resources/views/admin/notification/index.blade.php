@extends('layouts.dashboard')

@section('content')
    <div class="container border-0 my-2">
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
@endsection
