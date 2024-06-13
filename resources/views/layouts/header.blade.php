<header>
    <div class="header-inner will-stick">
        <div class="container">
            <div class="row-a">
                <div class="logo-area">
                    <a href="#!">
                        <img src="assets/images/logo.webp" class="img-fluid logo-a" alt="">
                    </a>
                </div>
                <div class="nav-area">
                    <ul class="menu-ul">
                        <li><a href="{{ route('dashboard.index') }}">Home</a></li>
                        @if (auth()->check() && auth()->user()->role_id == 3)
                            <li><a href="{{ route('user.about') }}">About</a></li>
                        @endif
                        <li><a href="#!">Model Search</a></li>
                        <li><a href="#!">Galleries</a></li>
                        <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li>
                            <a class="#" data-bs-toggle="offcanvas" href="#blogSearchCanvas" role="button"
                                aria-controls="blogSearchCanvas">
                                <i class="ri-search-line"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="offcanvas offcanvas-top" tabindex="-1" id="blogSearchCanvas"
                    aria-labelledby="blogSearchCanvasLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body my-4">
                        <form action="{{ route('blog.search') }}" method="GET">
                            <input type="text" name="search" placeholder="Search blogs">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
