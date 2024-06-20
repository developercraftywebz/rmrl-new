<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/minton/layouts/creative/layouts-vertical.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jun 2022 11:38:21 GMT -->
<head>

        <meta charset="utf-8" />
        <title>RMRL Dashboard</title>
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

    <body class="loading">
        

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
    
                    <ul class="list-unstyled topnav-menu float-end mb-0">
    
                        <li class="dropdown d-inline-block d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Search">
                                </form>
                            </div>
                        </li>

                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset('asset/images/dashboard/ic_Chat-6.png')}}" class="img-fluid"/>
                                <span class="badge bg-danger rounded-circle noti-icon-badge">5</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg">
    
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="#" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>
    
                                <div class="noti-scroll" data-simplebar>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                        <div class="notify-icon bg-soft-primary text-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Doug Dukes commented on Admin Dashboard
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{asset('asset/images/users/avatar-2.jpg ')}}" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Mario Drummond</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{asset('asset/images/users/avatar-4.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-soft-warning text-warning">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-secondary">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
                                        </p>
                                    </a>
                                </div>
    
                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fe-arrow-right"></i>
                                </a>
    
                            </div>
                        </li>
            
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-bell noti-icon"></i>
                                <span class="badge bg-danger rounded-circle noti-icon-badge">5</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg">
    
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="#" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>
    
                                <div class="noti-scroll" data-simplebar>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                        <div class="notify-icon bg-soft-primary text-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Doug Dukes commented on Admin Dashboard
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{asset('asset/images/users/avatar-2.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Mario Drummond</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{asset('asset/images/users/avatar-4.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-soft-warning text-warning">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-secondary">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
                                        </p>
                                    </a>
                                </div>
    
                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fe-arrow-right"></i>
                                </a>
    
                            </div>
                        </li>
    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset('asset/images/dashboard/Group 22.png')}}" alt="user-image" class="rounded">
                                <span class="pro-user-name ms-1">
                                     <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>
    
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-account-circle-line"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-settings-3-line"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-wallet-line"></i>
                                    <span>My Wallet <span class="badge bg-success float-end">3</span> </span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-lock-line"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!--<div class="dropdown-divider"></div>-->

                                <!-- item-->
                                <!--<a href="javascript:void(0);" class="dropdown-item notify-item">-->
                                <!--    <i class="ri-logout-box-line"></i>-->
                                <!--    <span>Logout</span>-->
                                <!--</a>-->
    
                            </div>
                        </li>
    
    
                    </ul>

                    <!-- LOGO -->
                    <!-- <div class="logo-div">
                        <a href="index.html" class="logo">
                            <div class="logo-img">
                                <img src="asset/images/dashboard/logo.png" alt="">-->
                                <!-- <span class="logo-lg-text-light">Minton</span> -->
                            <!-- </div>
                        </a>
                    </div> -->
    
                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li class="d-none d-lg-block">
                            <form class="app-search">
                                <div class="app-search-box dropdown">
                                    <div class="input-group">
                                        <input type="search" class="form-control" placeholder="Search..." id="top-search">
                                        <button class="btn" type="submit">
                                            <i class="fe-search"></i>
                                        </button>
                                    </div>
                                    <div class="dropdown-menu dropdown-lg" id="search-dropdown">
                                        <!-- item-->
                                        <div class="dropdown-header noti-title">
                                            <h5 class="text-overflow mb-2">Found <span class="text-danger">09</span> results</h5>
                                        </div>
            
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <i class="fe-home me-1"></i>
                                            <span>Analytics Report</span>
                                        </a>
            
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <i class="fe-aperture me-1"></i>
                                            <span>How can I help you?</span>
                                        </a>
                            
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <i class="fe-settings me-1"></i>
                                            <span>User profile settings</span>
                                        </a>

                                        <!-- item-->
                                        <div class="dropdown-header noti-title">
                                            <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                                        </div>

                                        <div class="notification-list">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="d-flex">
                                                    <img class="d-flex me-2 rounded-circle" src="{{asset('asset/images/users/avatar-2.jpg')}}" alt="Generic placeholder image" height="32">
                                                    <div>
                                                        <h5 class="m-0 font-14">Erwin E. Brown</h5>
                                                        <span class="font-12 mb-0">UI Designer</span>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="d-flex">
                                                    <img class="d-flex me-2 rounded-circle" src="{{asset('asset/images/users/avatar-5.jpg')}}" alt="Generic placeholder image" height="32">
                                                    <div>
                                                        <h5 class="m-0 font-14">Jacob Deo</h5>
                                                        <span class="font-12 mb-0">Developer</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
            
                                    </div>  
                                </div>
                            </form>
                        </li>
                        
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <!-- LOGO -->
                <div class="logo-area">
                    <a href="index.html" class="logo">
                        <div class="logo-img">
                            <img src="{{asset('asset/images/dashboard/RMRL-Logo-CW2-Black (2).png')}}" class="img-fluid" alt="">
                            <!-- <span class="logo-lg-text-light">Minton</span> -->
                        </div>
                    </a>
                </div>

                <div class="h-100" data-simplebar>

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="{{asset('asset/images/users/avatar-1.jpg')}}" alt="user-img" title="Mat Helme"
                            class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="#" class="text-reset dropdown-toggle h5 mt-2 mb-1 d-block"
                                data-bs-toggle="dropdown">Nik Patel</a>
                            <div class="dropdown-menu user-pro-dropdown">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </div>
                        <p class="text-reset">Admin Head</p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="login-name">
                            <li>
                                    <img src="{{asset('asset/images/dashboard/Group 22.png')}}" alt="user-image" class="rounded">
                                    <span class="pro-user-name ms-1">
                                         {{auth()->user()->first_name . '    ' . auth()->user()->last_name}}
                                    </span>
                            </li>
                        </ul>
                        <ul id="side-menu">

                            <!-- <li class="menu-title">Navigation</li> -->
                            <li>
                                <a href="#">
                                    <image class="" src="{{asset('asset/images/dashboard/ic_Dashboard.png')}}" />
                                    <span> Home </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <image class="" src="{{asset('asset/images/dashboard/ic_Dashboard-2.png')}}" />
                                    <span> Explore </span>
                                </a>
                            </li>
                            @if(auth()->user()->role_id == 3)
                            <li>
                                <a href="{{route('users.index')}}">
                                    <image class="" src="{{asset('asset/images/dashboard/ic_Dashboard-3.png')}}" />
                                    <span> User Management </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('subscriptions.index') }}">
                                    <image class="" src="{{asset('asset/images/dashboard/ic_Dashboard-4.png')}}" />
                                    <span> Subscription </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('cms')}}">
                                    <image class="" src="{{asset('asset/images/dashboard/ic_Dashboard-5.png')}}" />
                                    <span> CMS </span>
                                </a>
                            </li>
                  
                            <li>
                                <a href="{{ route('chat') }}">
                                    <image class="" src="{{asset('asset/images/dashboard/ic_Chat7.png')}}" />
                                    <span> Messages </span>
                                </a>
                            </li>
                            @endif
                          <li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <img src="{{ asset('asset/images/dashboard/ic_Dashboard-9.png') }}" alt="Logout Icon" />
        <span> Logout </span>
    </a>
</li>

                
                            
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-xl-8 col-8">
                                        <div class="post-div mt-3" id="style-3">
                                            <div class="whatpost-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="whatpost-title">Post Something</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <ul class="what-post d-flex justify-content-between gap-2">
                                                            <li class="what-post-item w-5"><img src="{{asset('asset/images/dashboard/PP1.png')}}"  class="img-fluid"/></li>
                                                            <li class="what-post-item w-95 what-post-input"><input type="text" name="what" placeholder="What’s on your mind?"></li>
                                                            <!-- <li class="what-post-item w-5"><img src="{{asset('asset/images/dashboard/ic_Image.png')}}"  class="img-fluid"/></li> -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-box mt-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <ul class="what-post d-flex justify-content-between gap-2">
                                                            <li class="what-post- w-5"><img src="{{asset('asset/images/dashboard/PP1.png')}}"  class="img-fluid"/></li>
                                                            <li class="what-post-item post-name w-95"><h4 class="post-title">RMRL</h4>
                                                                                                    <p>12 April at 09.28 PM</p>
                                                            </li>
                                                            <!-- <li class="what-post-item w-5"><img src="{{asset('asset/images/dashboard/ic_Image.png')}}"  class="img-fluid"/></li> -->
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
                                                        <img class="my-3 img-fluid" src="{{asset('asset/images/dashboard/Post Photos-04.png')}}"  class="img-fluid"/>
                                                        <h3 class="post-desc-head">It is a long established fact that a reader will be 
                                                        distracted by the readable</h3>
                                                        <p class="post-desc-p">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content 
here, content here', making it look like readable English.</br></br>

It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content 
here, content here', making it look like readable English.</br></br>

It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content 
here, content here', making it look like readable English.</br></br>

It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content 
here, content here', making it look like readable English.</p>
                                                        <ul class="comment-list d-flex gap-3">
                                                            <li>
                                                                <img src="{{asset('asset/images/dashboard/date.png')}}"  class="img-fluid"/><span>Posted By: 6/10/2024</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{asset('asset/images/dashboard/ic_comment.png')}}"  class="img-fluid"/><span>25 Comments</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <ul class="what-post d-flex justify-content-between gap-2">
                                                            <li class="what-post-item w-5"><img src="{{asset('asset/images/dashboard/Group 22.png')}}"  class="img-fluid"/></li>
                                                            <li class="what-post-item w-95 what-post-input comment-input"><input type="text" name="what" placeholder="Write your comment…"></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                                                                    

                                            </div>
                        
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-4">
                                        <div class="chat-div">
                                            <div class="whatpost-box chat-head-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="chatpost-title">CHATS</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <ul class="chat-post">
                                                            <li class="d-flex gap-2 align-items-center">
                                                                <a class="" href="#">
                                                                    <i class="fe-search noti-icon"></i>
                                                                </a>
                                                                <div class="p-0">
                                                                    <form class="">
                                                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Search">
                                                                    </form>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>                                                                                                                                                      

                                            </div>
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Cynthia Cox </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>

                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-2.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">John Doe </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>

                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-3.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Elley Cruz </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>

                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-4.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Cynthia Cox </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                            
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Group 22-b.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Marshall </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                            
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-6.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Illiana Doe </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                            
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-7.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Cynthia Cox </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                            
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-8.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Rehana Alie </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                            
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-9.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Elley Cruz </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                                                                        
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Group 22-c.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Cynthia Cox </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                                                                        
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-11.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Tom Cruz </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                                                                        
                                            <div class="chat-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="chat-post d-flex justify-content-between gap-2">
                                                            <div class="chat-post-item d-flex justify-content-between gap-2"> 
                                                                <div class="chat-img"><img src="{{asset('asset/images/dashboard/Initial_PP_32px-12.png')}}"  class="img-fluid"/></div>
                                                                <div class="chat-name"><p class="chat-title">Illiana Doe </br><span>Hello RMRL...</span></p></div>
                                                            </div>
                                                        
                                                            <div class="chat-post-item chat-time">11 min</div>
                                                        </div>
                                                    </div>
                                                </div>                                                  
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>  
                        <!-- end page title --> 

                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <!-- <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> &copy; Minton theme by <a href="#">Coderthemes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> -->
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-bordered nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link py-2" data-bs-toggle="tab" href="#chat-tab" role="tab">
                            <i class="mdi mdi-message-text-outline d-block font-22 my-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2" data-bs-toggle="tab" href="#tasks-tab" role="tab">
                            <i class="mdi mdi-format-list-checkbox d-block font-22 my-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 active" data-bs-toggle="tab" href="#settings-tab" role="tab">
                            <i class="mdi mdi-cog-outline d-block font-22 my-1"></i>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content pt-0">
                    <div class="tab-pane" id="chat-tab" role="tabpanel">
                
                        <form class="search-bar p-3">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="mdi mdi-magnify"></span>
                            </div>
                        </form>

                        <h6 class="fw-medium px-3 mt-2 text-uppercase">Group Chats</h6>

                        <div class="p-2">
                            <a href="javascript: void(0);" class="text-reset notification-item ps-3 mb-2 d-block">
                                <i class="mdi mdi-checkbox-blank-circle-outline me-1 text-success"></i>
                                <span class="mb-0 mt-1">App Development</span>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item ps-3 mb-2 d-block">
                                <i class="mdi mdi-checkbox-blank-circle-outline me-1 text-warning"></i>
                                <span class="mb-0 mt-1">Office Work</span>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item ps-3 mb-2 d-block">
                                <i class="mdi mdi-checkbox-blank-circle-outline me-1 text-danger"></i>
                                <span class="mb-0 mt-1">Personal Group</span>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item ps-3 d-block">
                                <i class="mdi mdi-checkbox-blank-circle-outline me-1"></i>
                                <span class="mb-0 mt-1">Freelance</span>
                            </a>
                        </div>

                        <h6 class="fw-medium px-3 mt-3 text-uppercase">Favourites <a href="javascript: void(0);" class="font-18 text-danger"><i class="float-end mdi mdi-plus-circle"></i></a></h6>

                        <div class="p-2">
                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status"></span>
                                        <img src="{{asset('asset/images/users/avatar-10.jp')}}g" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Andrew Mackie</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">It will seem like simplified English.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status"></span>
                                        <img src="{{asset('asset/images/users/avatar-1.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Rory Dalyell</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">To an English person, it will seem like simplified</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status busy"></span>
                                        <img src="{{asset('asset/images/users/avatar-9.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Jaxon Dunhill</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">To achieve this, it would be necessary.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <h6 class="fw-medium px-3 mt-3 text-uppercase">Other Chats <a href="javascript: void(0);" class="font-18 text-danger"><i class="float-end mdi mdi-plus-circle"></i></a></h6>

                        <div class="p-2 pb-4">
                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status online"></span>
                                        <img src="{{asset('asset/images/users/avatar-2.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Jackson Therry</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">Everyone realizes why a new common language.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status away"></span>
                                        <img src="{{asset('asset/images/users/avatar-4.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Charles Deakin</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">The languages only differ in their grammar.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status online"></span>
                                        <img src="{{asset('asset/images/users/avatar-5.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Ryan Salting</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">If several languages coalesce the grammar of the resulting.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status online"></span>
                                        <img src="{{asset('asset/images/users/avatar-6.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Sean Howse</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">It will seem like simplified English.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status busy"></span>
                                        <img src="{{asset('asset/images/users/avatar-7.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Dean Coward</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">The new common language will be more simple.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-2">
                                        <span class="user-status away"></span>
                                        <img src="{{asset('asset/images/users/avatar-8.jpg')}}" class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="mt-0 mb-1 font-14">Hayley East</h6>
                                        <div class="font-13 text-muted">
                                            <p class="mb-0 text-truncate">One could refuse to pay expensive translators.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div class="text-center mt-3">
                                <a href="javascript:void(0);" class="btn btn-sm btn-white">
                                    <i class="mdi mdi-spin mdi-loading me-2"></i>
                                    Load more
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="tasks-tab" role="tabpanel">
                        <h6 class="fw-medium p-3 m-0 text-uppercase">Working Tasks</h6>
                        <div class="px-2">
                            <a href="javascript: void(0);" class="text-reset item-hovered d-block p-2">
                                <p class="text-muted mb-0">App Development<span class="float-end">75%</span></p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset item-hovered d-block p-2">
                                <p class="text-muted mb-0">Database Repair<span class="float-end">37%</span></p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 37%" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset item-hovered d-block p-2">
                                <p class="text-muted mb-0">Backup Create<span class="float-end">52%</span></p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 52%" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                        </div>

                        <h6 class="fw-medium px-3 mb-0 mt-4 text-uppercase">Upcoming Tasks</h6>

                        <div class="p-2">
                            <a href="javascript: void(0);" class="text-reset item-hovered d-block p-2">
                                <p class="text-muted mb-0">Sales Reporting<span class="float-end">12%</span></p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset item-hovered d-block p-2">
                                <p class="text-muted mb-0">Redesign Website<span class="float-end">67%</span></p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>

                            <a href="javascript: void(0);" class="text-reset item-hovered d-block p-2">
                                <p class="text-muted mb-0">New Admin Design<span class="float-end">84%</span></p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 84%" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                        </div>

                        <div class="d-grid p-3 mt-2">
                            <a href="javascript: void(0);" class="btn btn-success waves-effect waves-light">Create Task</a>
                        </div>

                    </div>
                    <div class="tab-pane active" id="settings-tab" role="tabpanel">
                        <h6 class="fw-medium px-3 m-0 py-2 font-13 text-uppercase bg-light">
                            <span class="d-block py-1">Theme Settings</span>
                        </h6>

                        <div class="p-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                            </div>

                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light" id="light-mode-check" checked>
                                <label class="form-check-label" for="light-mode-check">Light Mode</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark" id="dark-mode-check">
                                <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                            </div>

                            <!-- Width -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check" checked>
                                <label class="form-check-label" for="fluid-check">Fluid</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                                <label class="form-check-label" for="boxed-check">Boxed</label>
                            </div>
                   

                            <!-- Topbar -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="topbar-color" value="dark" id="darktopbar-check" checked>
                                <label class="form-check-label" for="darktopbar-check">Dark</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="topbar-color" value="light" id="lighttopbar-check">
                                <label class="form-check-label" for="lighttopbar-check">Light</label>
                            </div>


                            <!-- Menu positions -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menus Positon <small>(Leftsidebar and Topbar)</small></h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="menus-position" value="fixed" id="fixed-check" checked>
                                <label class="form-check-label" for="fixed-check">Fixed</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="menus-position" value="scrollable" id="scrollable-check">
                                <label class="form-check-label" for="scrollable-check">Scrollable</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary" id="resetBtn">Reset to Default</button>

                            <a href="https://wrapbootstrap.com/theme/minton-admin-dashboard-landing-template-WB0858DB6?ref=coderthemes"
                                class="btn btn-danger mt-2" target="_blank"><i class="mdi mdi-basket me-1"></i> Purchase Now</a>
                            </div>

                        </div>

                    </div>
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

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