<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
    <div class="header">
        <a class="text-decoration-none " href="/">
            <img src="{{ url('./assets/img/icons/logo-blues.png') }}" alt=""> Bluesclues
        </a>
    </div>
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : 'text-light' }}" aria-current="page"
                    href="/admin/dashboard">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/news*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/news">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    News
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/merchandise*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/merchandise">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Merchandise
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/orders*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/orders">
                    <span data-feather="shopping-bag" class="align-text-bottom"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/events*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/events">
                    <span data-feather="calendar" class="align-text-bottom"></span>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/show-requests*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/show-requests?status=awaiting-approval">
                    <span data-feather="mic" class="align-text-bottom"></span>
                    Show Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/messages*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/messages">
                    <span data-feather="message-square" class="align-text-bottom"></span>
                    Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/songs*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/songs">
                    <span data-feather="music" class="align-text-bottom"></span>
                    Songs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/admins*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/admins">
                    <span data-feather="shield" class="align-text-bottom"></span>
                    Admins
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/users*') ? 'active' : 'text-light' }}"
                    href="/admin/dashboard/users">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <form id="logoutForm" action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="nav-link" style="color: #fff;"><i class="fas fa-right-from-bracket"
                            style=" margin-right: 4px;"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
