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

    <!-- Show all the member applications -->
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Member Requests:
                                        <span>{{ $applicants->count() }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (isset($applicants))
                        <div class="card mb-3 p-3">
                            @foreach ($applicants as $applicant)
                                <div class="row g-0">
                                    <div class="col-12">
                                        <!-- Show all applicants -->
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-1">
                                                <img src="{{ $applicant->user->profile_picture }}"
                                                    class="img-fluid rounded-circle" alt="...">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        {{ $applicant->user->first_name }}
                                                        {{ $applicant->user->last_name }}
                                                    </h6>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            Members
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mx-3">
                                                <form action="{{ route('accept.members', ['id' => $applicant->group_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="group_id"
                                                        value="{{ $applicant->group_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $applicant->user_id }}">
                                                    <button type="submit" class="ps-btn postbox-submit px-4 py-2">
                                                        <i class="ri-user-add-fill"></i>
                                                        Add
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-2">
                                                <form action="{{ route('reject.members', ['id' => $applicant->group_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="group_id"
                                                        value="{{ $applicant->group_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $applicant->user_id }}">
                                                    <button type="submit" class="ps-btn postbox-submit px-4 py-2">
                                                        <i class="ri-user-unfollow-fill"></i>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
