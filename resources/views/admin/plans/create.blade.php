<?php

use App\Enums\UserTypes;

?>

@extends('layouts.dashboard')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container w-100">
                <nav aria-label="breadcrumb" class="my-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Plan
                        </li>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <form method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="h5 mb-2 text-gray-800">Plan Details</h5>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input id="name" type="text" name="name"
                                                    value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror" />
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="feature_count">Feature Count</label>
                                                <input id="feature_count" type="number" name="feature_count"
                                                    value="{{ old('feature_count') }}"
                                                    class="form-control @error('feature_count') is-invalid @enderror" min="1" pattern="\d*"/>
                                                @error('feature_count')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input id="price" type="text" name="price"
                                                    value="{{ old('price')  }}"
                                                    class="form-control @error('price') is-invalid @enderror" />
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slug">Slug</label>
                                                <input id="slug" type="text" name="slug"
                                                    class="form-control"  />
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="recurring">Recurr   ance</label>
                                                <select name="recurring" id="recurring" class="form-control">
                                                    <option selected disabled>Select Any One</option>
                                                    <option value="week">Weekly</option>
                                                    <option value="month">Monthly</option>
                                                    <option value="year">Yearly</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency">Currency</label>
                                                <input id="currency" type="text" name="currency"
                                                    value="{{ old('currency') }}"
                                                    class="form-control @error('currency') is-invalid @enderror" />
                                                @error('currency')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="2" class="form-control @error('description') is-invalid @enderror">{{old('description') }}</textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mt-2">
                                                <button type="submit" class="ps-btn postbox-submit">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

