<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid content-navbar">
        <div class="col-lg-1">
            <div class="nav-logo">
                <img src="{{ url('./assets/img/icons/logo-blues.png') }}" class="img-logo" alt="">
            </div>
        </div>
        <div class="col-lg-8 ">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg"
                aria-controls="navbarOffcanvasLg" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvasLg"
                aria-labelledby="navbarOffcanvasLgLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Blues Clues</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) === null ? 'active' : '' }}"
                                href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) == 'about' ? 'active' : '' }}"
                                href="/about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) == 'news' ? 'active' : '' }}"
                                href="/news">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) == 'store' ? 'active' : '' }}"
                                href="/store">Store</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) == 'events' ? 'active' : '' }}"
                                href="/events">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) == 'videos' ? 'active' : '' }}"
                                href="/videos">Videos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(1) == 'music' ? 'active' : '' }}"
                                href="/music">Music</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-1 icons">
            <a href="#">
                <img src="{{ url('./assets/img/icons/person.svg') }}" alt="">
            </a>
            <a href="#">
                <img src="{{ url('./assets/img/icons/cart.svg') }}" alt="">
            </a>
        </div>
    </div>
</nav>
