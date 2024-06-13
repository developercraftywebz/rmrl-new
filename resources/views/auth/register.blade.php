<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/minton/layouts/creative/layouts-vertical.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jun 2022 11:38:21 GMT -->

<head>

    <meta charset="utf-8" />
    <title>RMRL Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="">

    <!-- plugin css -->
    <link href="{{ asset('asset/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css')}}" />

    <!-- App css -->
    <link href="{{ asset('asset/css/creative/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('asset/css/creative/app.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('asset/css/creative/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('asset/css/creative/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('asset/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- css -->
    <link href="{{ asset('asset/css/my-style.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- LOGO -->
                    <div class="logo text-center py-4">
                        <a href="index.html" class="logo">
                            <div class="logo-img text-center">
                                <img src="{{ asset('asset/images/dashboard/RMRL-Logo-CW2-Black (2).png')}}" class="img-fluid text-center" alt="">
                                <!-- <span class="logo-lg-text-light">Minton</span> -->
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
               
                    <div class="login-box mx-auto my-0">
                    @if (session('flash_success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('flash_success') }}
                    </div>
                    @elseif(session('flash_error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('flash_error') }}
                    </div>
                    @endif
                        <h4 class="login-title text-center">Register</h4>
                        <p class="login-p text-center">It is a long established fact that a reader will be distracted by the
                            readable content of a page when looking at its layout. </p>
                            <form action="{{ route('register') }}" class="login-form mx-auto my-0" method="POST">
                @csrf
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" id="fname" name="first_name" placeholder="First Name* " >
                                    @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="lname" name="last_name" placeholder="Last Name*" >
                                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="tel" id="phone" name="contact_number" placeholder="Phone*" >
                                    @error('contact_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="email" id="email" name="email" placeholder="Email*" >
                                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-6">
                                    <input type="password" id="password" name="password" placeholder="Password" >
                                    @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                                </div>
                                <div class="col-6">
                                    <input type="password" id="cpassword" name="password_confirmation" placeholder="Confirm Password" >
                                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                                </div>
                            </div>

                            <button type="submit" value="Register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
    </section>

    <!-- Vendor js -->
    <script src="{{ asset('asset/js/vendor.min.js')}}"></script>

    <!-- Apex js-->
    <script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('asset/libs/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('asset/libs/jquery.scrollto/jquery.scrollTo.min.js')}}"></script>

    <!-- Dashboard init-->
    <script src="{{ asset('asset/js/pages/dashboard-crm.init.js')}}"></script>

    <!-- Dashboard init-->
    <script src="{{ asset('asset/js/pages/dashboard-sales.init.js')}}"></script>

    <!--C3 Chart-->
    <script src="{{ asset('asset/libs/d3/d3.min.js')}}"></script>
    <script src="{{ asset('asset/libs/c3/c3.min.js')}}"></script>

    <!-- Init js -->
    <script src="{{ asset('asset/js/pages/c3.init.js')}}"></script>
    <script src="{{ asset('asset/js/pages/apexcharts.init.js')}}"></script>

    <!-- App js -->
    <script src="{{ asset('asset/js/app.min.js')}}"></script>


</body>

<!-- Mirrored from coderthemes.com/minton/layouts/creative/layouts-vertical.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jun 2022 11:39:26 GMT -->

</html>