@extends('layouts.group_dashboard')

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

    <!-- Show list for accepted members -->
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <!-- active users -->
                    <div class="card mb-3 p-3">
                        <div class="row g-0">
                            <div class="col-12">
                                <h5 class="col-md-10 pb-3">
                                    Active users:
                                    <span>{{ $activeUsers->count() }}</span>
                                </h5>
                                <div class="row g-0 align-items-center">
                                    @foreach ($activeUsers as $activeUser)
                                        <div class="col-6">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    {{ $activeUser->first_name . ' ' . $activeUser->last_name }}
                                                </h6>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        Member
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <img src="{{ $activeUser->profile_picture }}" class="img-fluid rounded-circle"
                                                alt="...">
                                        </div>
                                        <div class="col-5">
                                            <form action="{{ route('send.invites', ['id' => $secretGroup]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="group_id" value="{{ $secretGroup->id }}">
                                                <input type="hidden" name="user_id" value="{{ $activeUser->id }}">
                                                <button class="ps-btn postbox-submit">
                                                    Send invitation
                                                    <i class="ri-user-received-2-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
