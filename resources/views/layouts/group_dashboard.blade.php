<?php

use App\Helpers\Media;
use App\Enums\UserTypes;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Real Men Real Life</title>
    {{-- <meta name="description" content="<?php echo $_tpl['meta_desc']; ?>"> --}}
    <link id="favicon" rel="shortcut icon" href="{{ asset('assets/images/fav.webp') }}" />

    <link href="{{ asset('assets/css/remixicon.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/slick-theme.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simple-lightbox.min.css') }}" />

    <link href="{{ asset('assets/css/custom.css') }}?{{ rand(10, 100) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/my-style.css') }}?{{ rand(10, 100) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/select2.css') }}?{{ rand(10, 100) }}" rel="stylesheet" type="text/css" />

    <!-- JQuery library -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Include the DataTables library -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
@include('layouts.header') <!-- Same as profile -->
@include('layouts.admin_bar') <!-- Same as profile -->

@include('layouts.group_cover_section')

@yield('content')

@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/simple-lightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}?{{ rand(10, 100) }}"></script>
<script src="{{ asset('assets/js/select2.js') }}?{{ rand(10, 100) }}"></script>


</html>
