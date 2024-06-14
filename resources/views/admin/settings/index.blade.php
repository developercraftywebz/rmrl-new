<?php

use App\Enums\UserTypes;

?>

@extends('layouts.dashboard')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" class="my-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('flash_error'))
                            <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                        @endif
                        @if (session()->has('flash_success'))
                            <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                        @endif
                    </div>
                </div>
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="h5 mb-2 text-gray-800">Advanced Settings</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="admin_email">Admin Email</label>
                                                <input id="admin_email" type="email" name="admin_email"
                                                    value="{{ old('admin_email') ?? $admin_email }}"
                                                    class="form-control @error('admin_email') is-invalid @enderror" />
                                                @error('admin_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
