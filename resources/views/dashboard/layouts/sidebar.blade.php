<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : 'text-light' }}" aria-current="page" href="/admin/dashboard">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/news*') ? 'active' : 'text-light' }}" href="/admin/dashboard/news">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    News
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/merchandise*') ? 'active' : 'text-light' }}" href="/admin/dashboard/merchandise">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Merchandise
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/events*') ? 'active' : 'text-light' }}" href="/admin/dashboard/events">
                    <span data-feather="calendar" class="align-text-bottom"></span>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/songs*') ? 'active' : 'text-light' }}" href="/admin/dashboard/songs">
                    <span data-feather="music" class="align-text-bottom"></span>
                    Songs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard/profile*') ? 'active' : 'text-light' }}" href="/admin/dashboard/profile">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Profile
                </a>
            </li>
        </ul>
    </div>
</nav>