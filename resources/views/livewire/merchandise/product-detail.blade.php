<div class="container product-detail" id="productDetail">
    <div class="row justify-content-between">
        <div class="col-lg-6 detail-card">
            <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
        </div>
        <div class="col-lg-6 content">
            @if (session('success'))
                <div class="alert alert-box alert-dismissible">
                    <div class="content">
                        <h3>{{ session('success') }}</h3>
                        <div class="product-added">
                            <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
                            <p>{{ $product->name }}</p>
                        </div>

                        <a href="{{ route('merchandise.cart') }}" class="btn-alert cart">View My Cart</a>
                        <a href="{{ route('merchandise.cart') }}" class="btn-alert checkout">Checkout</a>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">continue
                            shopping</button>
                    </div>
                    {{-- <div class="alert-information">
                        <p>{{ session('success') }}</p>
                    </div> --}}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-box alert-dismissible">
                    <div class="content">
                        <h3>Your Shopping cart</h3>
                        <div class="product-added">
                            <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
                            <p>{{ $product->name }}</p>
                        </div>

                        <a href="{{ route('merchandise.cart') }}" class="btn-alert cart">View My Cart</a>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">continue
                            shopping</button>
                    </div>
                    <div class="alert-information">
                        <p>{{ session('error') }}</p>
                        {{-- <p>Product added to cart</p> --}}
                    </div>
                </div>
            @endif
            <div class="header">

                <h3 class="title">{{ $product->name }}</h3>
                <h3 class="price">rp {{ number_format($product->price, 0, ',', '.') }}
                    @if ($product->is_available == 1)
                        <span class="badge text-bg-success">Available</span>
                    @else
                        <span class="badge text-bg-danger">Sold Out</span>
                    @endif

                </h3>
            </div>
            <form>
                @if ($product->is_available == 1)
                    <div class="quantity">
                        <label for="quantity">Qty:</label>
                        <div class="quantity-control">
                            <button class="decrement" wire:click.prevent="decrementQuantity">-</button>
                            <input type="number" id="quantity" min="1" max="10"
                                wire:model.lazy="quantity">
                            <button class="increment" wire:click.prevent="incrementQuantity">+</button>

                        </div>
                    </div>
                    <button type="button" class="btn-merchan" wire:click="addToCart">Add to cart</button>

                    <div class="description">
                        <p>{{ $product->description }}</p>
                    </div>
                @else
                    <p class="text-center">Out of stock</p>
                @endif

            </form>
            {{-- <div class="noted">
                <p>Note: This product only available to ship in the <br> Jakarta and Malaysia</p>
            </div> --}}

        </div>
    </div>

</div>
<div class="container recommendations-section">
    <div class="row">
        <h1 class="text-center my-4">Product Recommendations</h1>
        <div class="content">
            @foreach ($products as $item)
                <a href="{{ route('product.detail', $item->slug) }}">
                    <div class="card">
                        <img src="{{ url('./assets/img/bc-1.png') }}" class="card-img-top" alt="...">
                        <button class="btn">Detail</button>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-price">rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
