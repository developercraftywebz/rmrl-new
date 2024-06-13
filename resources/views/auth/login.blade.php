<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/minton/layouts/creative/layouts-vertical.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jun 2022 11:38:21 GMT -->

<head>

    <meta charset="utf-8" />
    <title>RMRL Login</title>
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
                        <h4 class="login-title text-center">Login Now</h4>
                        <p class="login-p text-center">It is a long established fact that a reader will be distracted by the
                            readable content of a page when looking at its layout. </p>
                        <form action="{{ route('login') }}" class="login-form mx-auto my-0" method="POST">
                            @csrf

                            <input type="text" id="uname" name="email" placeholder="User Name*"><br>
                            <input type="password" id="password" name="password" placeholder="Password"><br><br>
                            <div class="row mb-5">
                                <div class="col-8">
                                    <!-- <input type="checkbox" id="remember" name="remember" value="Remember Me?">
            <label for="remember"> </label> -->
                                    <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="Remember Me?">
                                    <label for="styled-checkbox-2">Remember Me?</label>
                                </div>
                                <div class="col-4">
                                    <a href="#" class="rem-a">Forgot Password?</a>
                                </div>
                            </div>
                            <input type="submit" value="Login">
                        </form>
                        <p class="text-center rem-a" style="color: #FC5A5A;">Don't have an account? <a href="{{route('register')}}">Create new</a></p>


                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="login-post-box mx-auto my-4">
                            <div class="post-box mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="what-post d-flex justify-content-between gap-2">
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/PP1.png')}}" class="img-fluid" /></li>
                                            <li class="what-post-item post-name">
                                                <h4 class="post-title">RMRL</h4>
                                                <p>12 April at 09.28 PM</p>
                                            </li>
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/ic_Image.png')}}" class="img-fluid" /></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="post-status">Recent</p>
                                        <p class="post-desc">Images.... Fashion For Men</p>
                                        <img class="my-3 img-fluid" src="{{ asset('asset/images/dashboard/Post Photos.png')}}" class="img-fluid" />
                                        <ul class="comment-list">
                                            <li>
                                                <img src="{{ asset('asset/images/dashboard/ic_comment.png')}}" class="img-fluid" /><span>25 Comments</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <ul class="what-post d-flex justify-content-between gap-2">
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/Group 22.png')}}" class="img-fluid" /></li>
                                            <li class="what-post-item what-post-input comment-input"><input type="text" name="what" placeholder="Write your comment…"></li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                            <div class="post-box mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="what-post d-flex justify-content-between gap-2">
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/PP1.png')}}" class="img-fluid" /></li>
                                            <li class="what-post-item post-name">
                                                <h4 class="post-title">RMRL</h4>
                                                <p>12 April at 09.28 PM</p>
                                            </li>
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/ic_Image.png')}}" class="img-fluid" /></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="post-status">Recent</p>
                                        <p class="post-desc">Images.... Fashion For Men</p>
                                        <img class="my-3 img-fluid" src="{{ asset('asset/images/dashboard/Post Photos.png')}}" class="img-fluid" />
                                        <ul class="comment-list">
                                            <li>
                                                <img src="{{ asset('asset/images/dashboard/ic_comment.png')}}" /><span>25 Comments</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <ul class="what-post d-flex justify-content-between gap-2">
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/Group 22.png')}}" class="img-fluid" /></li>
                                            <li class="what-post-item what-post-input comment-input"><input type="text" name="what" placeholder="Write your comment…"></li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                            <div class="post-box mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="what-post d-flex justify-content-between gap-2">
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/PP1.png')}}" class="img-fluid" /></li>
                                            <li class="what-post-item post-name">
                                                <h4 class="post-title">RMRL</h4>
                                                <p>12 April at 09.28 PM</p>
                                            </li>
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/ic_Image.png')}}" class="img-fluid" /></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="post-status">Recent</p>
                                        <p class="post-desc">Images.... Fashion For Men</p>
                                        <img class="my-3 img-fluid" src="{{ asset('asset/images/dashboard/Post Photos.png')}}" class="img-fluid" />
                                        <ul class="comment-list">
                                            <li>
                                                <img src="{{ asset('asset/images/dashboard/ic_comment.png')}}" class="img-fluid" /><span>25 Comments</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <ul class="what-post d-flex justify-content-between gap-2">
                                            <li class="what-post-item"><img src="{{ asset('asset/images/dashboard/Group 22.png')}}" class="img-fluid" /></li>
                                            <li class="what-post-item what-post-input comment-input"><input type="text" name="what" placeholder="Write your comment…"></li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
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