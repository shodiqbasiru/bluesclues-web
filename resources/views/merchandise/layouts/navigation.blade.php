<nav class="navbar navbar-expand-lg" id="storeNav">
    <div class="nav-item">
        <a href="/store">Home</a>
    </div>
    <div class="nav-logo">
        <a href="/">

            <img src="{{ url('./assets/img/icons/logo_2.png') }}" alt="">
        </a>
    </div>
    <div class="icons">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ url('./assets/img/icons/person.svg') }}" alt="">
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <a href="{{ route('cart.index') }}" class="btn dropdown-toggle">
                <img src="{{ url('./assets/img/icons/cart.svg') }}" alt="">
            </a>
            <ul class="dropdown-menu cart-items">

            </ul>
        </div>

    </div>
</nav>