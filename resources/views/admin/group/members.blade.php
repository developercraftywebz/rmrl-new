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
                    <!-- Admin/Group Owner -->
                    <div class="card mb-3 p-3">
                        <div class="row g-0">
                            <div class="col-12">
                                <h5 class="col-md-10 pb-3">Admins · <span>1</span></h5>
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-1">
                                        <img src="{{ $admin->profile_picture }}" class="img-fluid rounded-circle"
                                            alt="...">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $admin->first_name . ' ' . $admin->last_name }}</h6>
                                            <p class="card-text"><small
                                                    class="text-muted">{{ $admin->role_id ? \App\Enums\UserTypes::LIST[3] : '' }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other users -->
                    <div class="card mb-3 p-3">
                        <div class="row g-0">
                            <div class="col-12">
                                <h5 class="col-md-10 pb-3">
                                    Members:
                                    <span>{{ $acceptedUsers->count() }}</span>
                                </h5>
                                <div class="row g-0 align-items-center">
                                    @foreach ($acceptedUsers as $acceptedUser)
                                        <div class="col-md-1">
                                            <img src="{{ $acceptedUser->user->profile_picture }}"
                                                class="img-fluid rounded-circle" alt="...">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    {{ $acceptedUser->user->first_name . ' ' . $acceptedUser->user->last_name }}
                                                </h6>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        Member
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <form action="{{ route('remove.members', ['id' => $acceptedUser->group_id]) }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="group_id"
                                                    value="{{ $acceptedUser->group_id }}">
                                                <input type="hidden" name="user_id" value="{{ $acceptedUser->user_id }}">
                                                <button type="submit" class="ps-btn postbox-submit px-3 py-2"><i
                                                        class="ri-user-unfollow-fill"></i>
                                                    Remove
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
