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
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ $users_url }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->first_name }}
                        {{ $user->last_name }}
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
                <div class="col-md-6">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="role_id">Account Type</label>
                                            <input id="role_id" type="text" value="{{ $user->Role->name }}" class="form-control" readonly disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') ?? $user->first_name }}" class="form-control @error('first_name') is-invalid @enderror" />
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') ?? $user->last_name }}" class="form-control @error('last_name') is-invalid @enderror" />
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" value="{{ $user->email }}" class="form-control" readonly disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control new">
                                                <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>
                                                    Disabled</option>
                                                <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>
                                                    Activated</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @php
                                $countries = Khsing\World\Models\Country::get();
                                @endphp


                                <div class="form-group">
                                    <label for="country_id">Country</label>
                                    <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror">
                                        <option selected disabled>Select Country</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
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
                                    <select name="state_id" id="state_id" class="form-control @error('state_id') is-invalid @enderror">
                                        <option selected disabled>Select State</option>
                                        @foreach ($states as $state)
                                        <option value="{{ $state->id }}" {{ $user->state_id == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control @error('city_id') is-invalid @enderror">
                                        <option selected disabled>Select City</option>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>



                                <!-- <div class="form-group">
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

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state_id">State</label>
                                                <select name="state_id" id="state_id"
                                                    class="form-control @error('state_id') is-invalid @enderror">
                                                    <option value="">Select State</option>
                                                    @foreach (getStates($user->country_id ) as $stateItem)
                                                        <option value="{{ $stateItem->id }}"
                                                            {{ $user->state_id == $stateItem->id ? 'selected' : '' }}>
                                                            {{ $stateItem->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('state_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="city_id">City</label>
                                                <select name="city_id" id="city_id"
                                                    class="form-control @error('city_id') is-invalid @enderror">
                                                    <option value="">Select City</option>
                                                </select>
                                                @error('city_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="zip_code">ZIP Code</label>
                                                <input id="zip_code" type="text" name="zip_code"
                                                    value="{{ old('zip_code') ?? $user->zip_code }}"
                                                    class="form-control @error('zip_code') is-invalid @enderror" />
                                                @error('zip_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_number">Contact Number</label>
                                                <input id="contact_number" type="text" name="contact_number"
                                                    value="{{ old('contact_number') ?? $user->contact_number }}"
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
                                                        @if ($user->profile_picture)
                                                            <img id="current-image"
                                                                src="{{ asset('images/users/' . $user->profile_picture) }}"
                                                                alt="{{ $user->user_name }}"
                                                                style="max-width: 200px; max-height: 200px; margin-top: 20px;">
                                                        @endif
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
                                    </div> -->



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
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="h5 mb-2 text-gray-800">Advanced Details</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Current OTP</label>
                                        <input type="text" readonly disabled value="{{ $user->otp }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Verified</label>
                                        <input type="text" readonly disabled value="{{ $user->status == '1' ? 'Yes' : 'No' }}" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const old_state_id = "{{ (old('state_id') ? old('state_id') : $user->state_id) ? $user->state_id : '' }}";
    const old_city_id = "{{ (old('city_id') ? old('city_id') : $user->city_id) ? $user->city_id : '' }}";

    function getCities(state_id) {
        const url = "{{ route('states.get-cities') }}"
        var html = "";

        $.ajax({
            url,
            type: 'GET',
            data: {
                state_id
            },
            success: function(response) {
                let html = "";

                response.forEach(element => {
                    html += `
                        <option value="${element.id}" ${old_city_id == element.id ? 'selected' : ''}>${element.name}</option>
                    `;
                });

                $("#city_id").html(html)
            }
        });
    }

    $(document).on("change", "#state_id", function(e) {
        const selectedState = e.target.value

        if (selectedState) {
            getCities(selectedState);
        }
    });

    if (old_state_id) {
        getCities(old_state_id);
    }

    function previewImage(event) {
        var input = event.target;
        var preview = document.getElementById('image-preview');
        var currentImage = document.getElementById('current-image');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.setAttribute('src', e.target.result);
                preview.style.display = 'block';
                if (currentImage) {
                    currentImage.style.display = 'none';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection