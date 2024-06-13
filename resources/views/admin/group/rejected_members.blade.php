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

    <!-- Show all the rejeceted applicants -->
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Blocked Members:
                                        <span>{{ $rejectedUsers->count() }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 p-3">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="row g-0 align-items-center">
                                    @foreach ($rejectedUsers as $rejectedUser)
                                        <div class="col-md-1">
                                            <img src="{{ $rejectedUser->user->profile_picture }}"
                                                class="img-fluid rounded-circle" alt="...">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    {{ $rejectedUser->user->first_name . ' ' . $rejectedUser->user->last_name }}
                                                </h6>
                                                <p class="card-text">
                                                    <small class="text-muted">Members</small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <form action="{{ route('unblock.members', ['id' => $rejectedUser->group_id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $rejectedUser->user_id }}">
                                                <input type="hidden" name="group_id" value="{{ $rejectedUser->group_id }}">
                                                <button type="submit" class="ps-btn postbox-submit px-2 py-2"><i
                                                    class="ri-user-add-fill"></i>
                                                Unblock
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
        </div>
    </section>
@endsection
