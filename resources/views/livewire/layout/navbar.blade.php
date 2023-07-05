<div>
    <nav class="navbar navbar-expand-lg" id="storeNav">
        <div class="container-fluid p-0">
            <a class="navbar-brand" href="/">
                <img src="{{ url('./assets/img/icons/logo_2.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchandise.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Category
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($categories as $category)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('product.category', $category->id) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                            <li>
                                <hr>
                                <a class="dropdown-item" href="{{ route('products') }}">All Products</a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">History</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto icons">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (auth()->check())
                                <img src="{{ url('./assets/img/icons/person.svg') }}" alt="">
                                {{ Auth::user()->username }}
                            @else
                                <img src="{{ url('./assets/img/icons/person.svg') }}" alt="">
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @if (auth()->check())
                                <li class="nav-item">

                                    <form action="{{ route('user.logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item dropdown cart">
                        {{-- @if (auth()->check()) --}}
                        <a class="nav-link dropdown-toggle position-relative" href="{{ route('merchandise.cart') }}">
                            <img src="{{ url('./assets/img/icons/cart.svg') }}" alt="">
                            @if ($count_order !== 0)
                                <span class="count">
                                    {{ $count_order }}
                                </span>
                            @endif
                        </a>
                        {{-- @else
                            <a class="nav-link d-none dropdown-toggle position-relative"
                                href="{{ route('merchandise.cart') }}">
                                <img src="{{ url('./assets/img/icons/cart.svg') }}" alt="">
                                @if ($count_order !== 0)
                                    <span class="count">
                                        {{ $count_order }}
                                    </span>
                                @endif
                            </a>
                        @endif --}}
                        <ul class="dropdown-menu cart">
                            @forelse ($products as $product)
                                <li class="dropdown-item list-products">
                                    <div class="img-dropdown">
                                        <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
                                    </div>
                                    <div class="text">
                                        <p class="p-name">
                                            {{ $product->merchandise->name }}
                                        </p>

                                        <p class="qty">
                                            qty : {{ $product->quantity }}
                                        </p>
                                    </div>
                                    <div class="price">
                                        <p>
                                            Rp {{ number_format($product->merchandise->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <li class="dropdown-item list-products">
                                    No Items
                                </li>
                            @endforelse

                            <li class="dropdown-item button">
                                <p>
                                    {{ $count_order <= 3 ? '' : $count_order - 3 . ' more products in cart' }}

                                </p>

                                <a class="btn btn-dropdown d-flex justify-content-center"
                                    href="{{ route('merchandise.cart') }}">View My Shopping Cart</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

{{-- 
<li class="nav-item">
    <a class="nav-link position-relative" href="{{ route('merchandise.cart') }}">
        <img src="{{ url('./assets/img/icons/cart.svg') }}" alt="">
        @if ($count_order !== 0)
            <span class="count">
                {{ $count_order }}
            </span>
        @endif
    </a>
</li> --}}
