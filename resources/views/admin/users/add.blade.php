<?php

use App\Enums\UserTypes;

?>

@extends('layouts.dashboard')

@section('content')
    <div class="">
        <div class="content">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" class="my-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                
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
                    <div class="col-6">
                        <div class="card shadow mb-4">
                            <form method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="h5 mb-2 text-gray-800">Personal Details</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input id="first_name" type="text" name="first_name"
                                                    class="form-control @error('first_name') is-invalid @enderror" />
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input id="last_name" type="text" name="last_name"
                                                    class="form-control @error('last_name') is-invalid @enderror" />
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input id="password" type="password" name="password"
                                                    class="form-control @error('email') is-invalid @enderror" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country_id">Country</label>
                                        <select name="country_id" id="country_id"
                                            class="form-control @error('country_id') is-invalid @enderror">
                                            <option selected disabled>Select Country</option>
                                            @foreach ($country as $country_item)
                                                <option value="{{ $country_item->id }}">{{ $country_item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="state_id">State</label>
                                        <select name="state_id" id="state_id"
                                            class="form-control @error('state_id') is-invalid @enderror">
                                            <option selected disabled>Select State</option>
                                        </select>
                                        @error('state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="city_id">City</label>
                                        <select name="city_id" id="city_id"
                                            class="form-control @error('city_id') is-invalid @enderror">
                                            <option selected disabled>Select City</option>
                                        </select>
                                        @error('city_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="zip_code">ZIP Code</label>
                                                <input id="zip_code" type="text" name="zip_code"
                                                    class="form-control @error('zip_code') is-invalid @enderror" />
                                                @error('zip_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="contact_number">Contact Number</label>
                                                <input id="contact_number" type="text" name="contact_number"
                                                    class="form-control @error('contact_number') is-invalid @enderror" />
                                                @error('contact_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input type="file" name="profile_picture" id="profile_picture"
                                                            class="form-control-file @error('profile_picture') is-invalid @enderror"
                                                            onchange="previewImage(event)">
                                                        @error('profile_picture')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div class="mt-2">
                                                            <img id="image-preview" src="#" alt="Image Preview"
                                                                style="max-width: 200px; max-height: 200px; display: none;">
                                                        </div>
                                                    </div>
                                                </div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Bind an event to the country dropdown change
            $('#country_id').change(function() {
                const countryId = $(this).val();
                if (countryId) {
                    // Make an AJAX request to get states based on the selected country
                    $.ajax({
                        url: "{{ route('states.get-states') }}",
                        method: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            // Populate the state dropdown with the retrieved data
                            $('#state_id').empty().append(
                                '<option  selected disabled>Select State</option>');
                            response.forEach(function(state) {
                                $('#state_id').append('<option value="' + state.id +
                                    '">' +
                                    state.name + '</option>');
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    // Clear the state dropdown when no country is selected
                    $('#state_id').empty().append('<option  selected disabled>Select State</option>');
                    $('#city_id').empty().append('<option  selected disabled>Select City</option>');
                }
            });

            // Bind an event to the state dropdown change
            $('#state_id').change(function() {
                const stateId = $(this).val();
                if (stateId) {
                    // Make an AJAX request to get cities based on the selected state
                    $.ajax({
                        url: "{{ route('states.get-cities') }}",
                        method: 'GET',
                        data: {
                            state_id: stateId
                        },
                        success: function(response) {
                            // Populate the city dropdown with the retrieved data
                            $('#city_id').empty().append(
                                '<option  selected disabled>Select City</option>');
                            response.forEach(function(city) {
                                $('#city_id').append('<option value="' + city.id +
                                    '">' +
                                    city.name + '</option>');
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    // Clear the city dropdown when no state is selected
                    $('#city_id').empty().append('<option  selected disabled>Select City</option>');
                }
            });
        });
    </script>
@endsection
