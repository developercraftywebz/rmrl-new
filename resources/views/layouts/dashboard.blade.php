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


    <link href="{{ asset('assets/css/creative/app.min.css') }}?{{ rand(10, 100) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/creative/app-dark.min.css') }}?{{ rand(10, 100) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}?{{ rand(10, 100) }}" rel="stylesheet" type="text/css" />

    <!-- JQuery library -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Include the DataTables library -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
      <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <!-- LOGO -->
            <div class="logo-box">
                <div class="logo-area">
                    <a href="#!">
                        <img src="assets/images/logo.webp" class="img-fluid logo-a" alt="">
                    </a>
                </div>
            </div>

            <div class="h-100" data-simplebar>

                <!-- User box -->
                <div class="user-box text-center">
                    <img src="../assets/images/users/avatar-1.jpg" alt="user-img" title="Mat Helme"
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

                    <ul id="side-menu">

                        <!--<li class="menu-title">Navigation</li>-->
            
                        <!--<li>-->
                        <!--    <a href="#sidebarDashboards" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarDashboards" class="waves-effect">-->
                        <!--        <i class="ri-dashboard-line"></i>-->
                        <!--        <span class="badge bg-success rounded-pill float-end">3</span>-->
                        <!--        <span> Dashboards </span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarDashboards">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="index.html">Sales</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="dashboard-crm.html">CRM</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="dashboard-analytics.html">Analytics</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarLayouts" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarLayouts">-->
                        <!--        <i class="ri-layout-line"></i>-->
                        <!--        <span> Layouts </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarLayouts">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="layouts-vertical.html">Vertical</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="index.html">Horizontal</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="layouts-detached.html">Detached</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="layouts-two-column.html">Two Column Menu</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="layouts-preloader.html">Preloader</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li class="menu-title mt-2">Apps</li>-->

                        <li>
                            <a href="#">
                                <i class="ri-home-4-fill"></i>
                                <span> Home </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#!">
                                <i class="ri-home-4-fill"></i>
                                <span> Explore </span>
                            </a>
                        </li>
                                                

                        <!--<li>-->
                        <!--    <a href="#sidebarEcommerce" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarEcommerce">-->
                        <!--        <i class="ri-shopping-cart-2-line"></i>-->
                        <!--        <span class="badge bg-danger float-end">New</span>-->
                        <!--        <span> Ecommerce </span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarEcommerce">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-products.html">Products List</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-products-grid.html">Products Grid</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-product-detail.html">Product Detail</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-product-create.html">Create Product</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-customers.html">Customers</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-orders.html">Orders</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-orders-detail.html">Order Detail</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-sellers.html">Sellers</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-cart.html">Shopping Cart</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ecommerce-checkout.html">Checkout</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->
                        
                        <li class="menu-title mt-2">Settings</li>

                        @if(auth()->user()->role_id == 1)
                       
                        <li>
                            <a href="{{route('chatNew')}}">
                                <i class="ri-profile-fill"></i>
                                <span> Contact Us </span>
                            </a>
                        </li>
                       
                        @endif
                        @if(auth()->user()->role_id == 3)
                        <li>
                            <a href="#setting" data-bs-toggle="collapse" aria-expanded="false" aria-controls="setting">
                                <i class="ri-account-circle-fill"></i>
                                <span> User Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="setting">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{route('users.index')}}"><i class="ri-shield-user-line"></i><span> User</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('admin.index')}}"><i class="ri-shield-user-line"></i><span> Admin</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('subscriptions.index') }}">
                                <i class="ri-profile-fill"></i>
                                <span> Subscription </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cms')}}">
                                <i class="ri-profile-fill"></i>
                                <span> CMS </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('chat') }}">
                                <i class="ri-file-list-2-line"></i>
                                <span> Messages </span>
                            </a>
                        </li>
                        @endif
                        <!--<li>-->
                        <!--    <a href="#sidebarEmail" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarEmail">-->
                        <!--        <i class="ri-account-circle-fill"></i>-->
                        <!--        <span> User Management </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarEmail">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="#!"><i class="ri-shield-user-line"></i>&nbsp; &nbsp; User</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="#!"><i class="ri-shield-user-line"></i>&nbsp; &nbsp; Admin</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="{{ route('subscriptions.index') }}">-->
                        <!--        <i class="ri-profile-fill"></i>-->
                        <!--        <span> Subscription </span>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarTasks" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarTasks">-->
                        <!--        <i class="ri-task-line"></i>-->
                        <!--        <span> Tasks </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarTasks">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="task-list.html">List</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="task-details.html">Details</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="task-kanban-board.html">Kanban Board</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="apps-tickets.html">-->
                        <!--        <i class="ri-customer-service-2-line"></i>-->
                        <!--        <span> Tickets </span>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarContacts" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarContacts">-->
                        <!--        <i class="ri-profile-line"></i>-->
                        <!--        <span> Contacts </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarContacts">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="contacts-list.html">Members List</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="contacts-profile.html">Profile</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="apps-file-manager.html">-->
                        <!--        <i class="ri-folders-line"></i>-->
                        <!--        <span> File Manager </span>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <!--<li class="menu-title mt-2">Custom</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarAuth" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarAuth">-->
                        <!--        <i class="ri-shield-user-line"></i>-->
                        <!--        <span> Auth Pages </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarAuth">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="auth-login.html">Log In</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-login-2.html">Log In 2</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-register.html">Register</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-register-2.html">Register 2</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-signin-signup.html">Signin - Signup</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-signin-signup-2.html">Signin - Signup 2</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-recoverpw.html">Recover Password</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-recoverpw-2.html">Recover Password 2</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-lock-screen.html">Lock Screen</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-lock-screen-2.html">Lock Screen 2</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-logout.html">Logout</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-logout-2.html">Logout 2</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-confirm-mail.html">Confirm Mail</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="auth-confirm-mail-2.html">Confirm Mail 2</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarExpages" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarExpages">-->
                        <!--        <i class="ri-pages-line"></i>-->
                        <!--        <span> Extra Pages </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarExpages">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="pages-starter.html">Starter</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-timeline.html">Timeline</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-sitemap.html">Sitemap</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-invoice.html">Invoice</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-faqs.html">FAQs</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-search-results.html">Search Results</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-pricing.html">Pricing</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-maintenance.html">Maintenance</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-coming-soon.html">Coming Soon</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-gallery.html">Gallery</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-404.html">Error 404</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-404-alt.html">Error 404-alt</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="pages-500.html">Error 500</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li class="menu-title mt-2">Components</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarBaseui" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarBaseui">-->
                        <!--        <i class="ri-pencil-ruler-2-line"></i>-->
                        <!--        <span> Base UI </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarBaseui">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="ui-avatars.html">Avatars</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-buttons.html">Buttons</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-cards.html">Cards</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-carousel.html">Carousel</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-dropdowns.html">Dropdowns</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-video.html">Embed Video</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-general.html">General UI</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-grid.html">Grid</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-images.html">Images</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-list-group.html">List Group</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-modals.html">Modals</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-notifications.html">Notifications</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-offcanvas.html">Offcanvas</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-placeholders.html">Placeholders</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-portlets.html">Portlets</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-progress.html">Progress</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-ribbons.html">Ribbons</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-spinners.html">Spinners</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-tabs-accordions.html">Tabs & Accordions</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-tooltips-popovers.html">Tooltips & Popovers</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="ui-typography.html">Typography</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarExtendedui" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarExtendedui">-->
                        <!--        <i class="ri-stack-line"></i>-->
                        <!--        <span class="badge bg-info float-end">Hot</span>-->
                        <!--        <span> Extended UI </span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarExtendedui">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="extended-nestable.html">Nestable List</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="extended-range-slider.html">Range Slider</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="extended-sweet-alert.html">Sweet Alert</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="extended-tour.html">Tour Page</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="extended-treeview.html">Treeview</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="extended-scrollspy.html">Scrollspy</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="widgets.html">-->
                        <!--        <i class="ri-honour-line"></i>-->
                        <!--        <span> Widgets </span>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarIcons" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarIcons">-->
                        <!--        <i class="ri-markup-line"></i>-->
                        <!--        <span> Icons </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarIcons">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="icons-feather.html">Feather</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="icons-remix.html">Remix</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="icons-boxicons.html">Boxicons</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="icons-mdi.html">Material Design</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="icons-font-awesome.html">Font Awesome 5</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="icons-weather.html">Weather</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarForms" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarForms">-->
                        <!--        <i class="ri-eraser-line"></i>-->
                        <!--        <span> Forms </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarForms">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="forms-elements.html">General Elements</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-advanced.html">Advanced</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-validation.html">Validation</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-pickers.html">Pickers</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-wizard.html">Wizard</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-masks.html">Masks</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-quilljs.html">Quilljs Editor</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-file-uploads.html">File Uploads</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="forms-x-editable.html">X Editable</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarTables" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarTables">-->
                        <!--        <i class="ri-table-line"></i>-->
                        <!--        <span> Tables </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarTables">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="tables-basic.html">Basic Tables</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="tables-datatables.html">Data Tables</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="tables-editable.html">Editable Tables</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="tables-responsive.html">Responsive Tables</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="tables-footables.html">FooTable</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="tables-tablesaw.html">Tablesaw Tables</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarCharts" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarCharts">-->
                        <!--        <i class="ri-bar-chart-line"></i>-->
                        <!--        <span> Charts </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarCharts">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="charts-flot.html">Flot</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-apex.html">Apex</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-morris.html">Morris</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-chartjs.html">Chartjs</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-c3.html">C3</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-peity.html">Peity</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-chartist.html">Chartist</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-sparklines.html">Sparklines</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="charts-knob.html">Jquery Knob</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarMaps" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMaps">-->
                        <!--        <i class="ri-map-pin-line"></i>-->
                        <!--        <span> Maps </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarMaps">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="maps-google.html">Google</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="maps-vector.html">Vector</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="maps-mapael.html">Mapael</a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->

                        <!--<li>-->
                        <!--    <a href="#sidebarMultilevel" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel">-->
                        <!--        <i class="ri-share-line"></i>-->
                        <!--        <span> Multi Level </span>-->
                        <!--        <span class="menu-arrow"></span>-->
                        <!--    </a>-->
                        <!--    <div class="collapse" id="sidebarMultilevel">-->
                        <!--        <ul class="nav-second-level">-->
                        <!--            <li>-->
                        <!--                <a href="#sidebarMultilevel2" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel2">-->
                        <!--                    Second Level <span class="menu-arrow"></span>-->
                        <!--                </a>-->
                        <!--                <div class="collapse" id="sidebarMultilevel2">-->
                        <!--                    <ul class="nav-second-level">-->
                        <!--                        <li>-->
                        <!--                            <a href="javascript: void(0);">Item 1</a>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <a href="javascript: void(0);">Item 2</a>-->
                        <!--                        </li>-->
                        <!--                    </ul>-->
                        <!--                </div>-->
                        <!--            </li>-->

                        <!--            <li>-->
                        <!--                <a href="#sidebarMultilevel3" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel3">-->
                        <!--                    Third Level <span class="menu-arrow"></span>-->
                        <!--                </a>-->
                        <!--                <div class="collapse" id="sidebarMultilevel3">-->
                        <!--                    <ul class="nav-second-level">-->
                        <!--                        <li>-->
                        <!--                            <a href="javascript: void(0);">Item 1</a>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <a href="#sidebarMultilevel4" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel4">-->
                        <!--                                Item 2 <span class="menu-arrow"></span>-->
                        <!--                            </a>-->
                        <!--                            <div class="collapse" id="sidebarMultilevel4">-->
                        <!--                                <ul class="nav-second-level">-->
                        <!--                                    <li>-->
                        <!--                                        <a href="javascript: void(0);">Item 1</a>-->
                        <!--                                    </li>-->
                        <!--                                    <li>-->
                        <!--                                        <a href="javascript: void(0);">Item 2</a>-->
                        <!--                                    </li>-->
                        <!--                                </ul>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                        <!--                    </ul>-->
                        <!--                </div>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
            <div class="content-page">
@include('layouts.header')
@include('layouts.admin_bar')

@include('layouts.cover_section')

@yield('content')

@include('layouts.footer')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/simple-lightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}?{{ rand(10, 100) }}"></script>
<script src="{{ asset('assets/js/select2.js') }}?{{ rand(10, 100) }}"></script>

<script src="{{ asset('assets/js/pages/jquery.todo.js') }}?{{ rand(10, 100) }}"></script>
<script src="{{ asset('assets/js/pages/dashboard-crm.init.js') }}?{{ rand(10, 100) }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}?{{ rand(10, 100) }}"></script>

</html>
