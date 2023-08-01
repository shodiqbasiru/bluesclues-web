<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" id="header">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="/">
        <img src="{{ url('./assets/img/icons/logo-blues.png') }}" alt=""> Blues Clues</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    {{-- <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <form id="logoutForm" action="{{ route('admin.logout') }}" method="post">
                @csrf
                <button type="submit" class="nav-link px-3"><span data-feather="log-out"
                        class="align-text-bottom"></span>
                    Logout</button>
            </form>
        </div>
    </div> --}}
</header>
