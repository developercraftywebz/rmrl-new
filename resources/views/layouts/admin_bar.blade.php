<style>
    .admin-bar-a {
        padding: 1rem 0;
    }
</style>

<section class="admin-bar-a">
    <div class="container w-100">
        <div class="admin-box-a">
            <div class="admin-left-a">
                <ul class="list-a admin-link-a">
                    <li><a href="#"><i class="ri-home-4-fill"></i></a></li>
                    <li><a href="#!"><i class="ri-checkbox-fill"></i></a></li>
                    <li><a href="#!"><i class="ri-bookmark-fill"></i></a></li>
                </ul>
                <ul class="list-a nav-links-a">
                    <li><a href="#!">Members</a></li>
                    <li><a href="{{ route('dashboard.group') }}">Groups</a></li>
                </ul>
            </div>
            <div class="admin-right-a">
                <div class="avatar-area">
                    <a href="#!" class="menu-item-has-children">
                        <div class="avtr-img">
                            <img src="{{ asset('assets/images/dashboard/profile-placeholder.svg') }}" alt="">
                        </div>
                        <p class="avtr-name">
                            {{ Auth::user()->first_name }}
                        </p>
                    </a>
                    <ul class="list-a dropdown-menu-a shadow">
                        <li><a class="dropdown-item" href="#"><i class="ri-home-5-fill"></i>
                                Home</a></li>
                        <li><a class="dropdown-item" href="#"><i class="ri-home-5-fill"></i>
                                Stream</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.about') }}"><i
                                    class="ri-account-circle-fill"></i> About</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.blog.view') }}"><i
                                    class="ri-double-quotes-r"></i> Blog</a></li>
                        <li><a class="dropdown-item" href="#!"><i class="ri-user-follow-fill"></i> Followers</a>
                        </li>
                        <li><a class="dropdown-item" href="#!"><i class="ri-group-fill"></i> Friends</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard.group') }}"><i
                                    class="ri-group-2-fill"></i> Groups</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard.category') }}">
                                <i class="ri-camera-switch-fill"></i> Photos /
                                <i class="ri-vidicon-line"></i> Videos
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('subscriptions.index') }}"><i
                                    class="ri-profile-fill"></i> Subscriptions</a></li>
                        <li><a class="dropdown-item" href="#!"><i class="ri-user-shared-2-fill"></i>
                                Settings</a>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="ri-logout-circle-r-line"></i>
                                    Log Out
                                </a>
                                <button class="btn btn-primary d-none" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                    
                </div>
                <ul class="list-a admin-right-link">
                    <li><a href="#!"><i class="ri-group-fill"></i></a></li>
                    <li><a href="#!"><i class="ri-mail-fill"></i></a></li>
                    <li><a href="#!"><i class="ri-notification-3-fill"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


<script>
    $('.avatar-area').on('click', function() {
        $('.dropdown-menu-a').toggleClass('active');
    });
</script>
