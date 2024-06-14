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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        CMS
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
                                        <h5 class="h5 mb-2 text-gray-800">CMS</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="banner_heading">Banner Heading</label>
                                            <input id="banner_heading" type="text" name="banner_heading" class="form-control @error('banner_heading') is-invalid @enderror" />
                                            @error('banner_heading')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="banner_description">Banner Description</label>
                                            <textarea id="banner_description" type="text" name="banner_description" class="form-control @error('banner_description') is-invalid @enderror"></textarea>
                                            @error('banner_description')
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
                                            <label for="about_heading">About Heading</label>
                                            <input id="about_heading" type="text" name="about_heading" class="form-control @error('about_heading') is-invalid @enderror" />
                                            @error('about_heading')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="about_description">About Description</label>
                                            <textarea id="about_description" type="text" name="about_description" class="form-control @error('about_description') is-invalid @enderror"></textarea>
                                            @error('about_description')
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
                                            <label for="gallery_heading">Gallery Heading</label>
                                            <input id="gallery_heading" type="text" name="gallery_heading" class="form-control @error('gallery_heading') is-invalid @enderror" />
                                            @error('gallery_heading')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="gallery_description">Gallery Description</label>
                                            <textarea id="gallery_description" type="text" name="gallery_description" class="form-control @error('gallery_description') is-invalid @enderror"></textarea>
                                            @error('gallery_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                <div class="row">

                                    <div class="col-12 mt-2">
                                        <label for="gallery_description">Banner Picture </label>

                                        <div class="card shadow mb-4">
                                            <div class="card-body">

                                                <div class="form-group">

                                                    <input type="file" name="banner_picture" id="banner_picture" class="form-control-file @error('banner_picture') is-invalid @enderror" onchange="previewImage(event)">
                                                    @error('banner_picture')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="image-preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-12 mt-2">
                                        <label for="gallery_description">About Picture </label>

                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input type="file" name="about_picture" id="about_picture" class="form-control-file @error('about_picture') is-invalid @enderror" onchange="previewImage(event)">
                                                    @error('about_picture')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="image-preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-12 mt-2">
                                        <label for="gallery_picture">Gallery Picture </label>

                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input type="file" name="gallery_picture" id="gallery_picture" class="form-control-file @error('gallery_picture') is-invalid @enderror" onchange="previewImage(event)">
                                                    @error('gallery_picture')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="image-preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
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