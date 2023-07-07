<div class="container product-detail" id="productDetail">
    <div class="row justify-content-between">
        @if (session('error'))
            <div class="alert alert-error alert-dismissible fade show" role="alert" id="errorAlert">
                <p>{{ session('error') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-lg-6 detail-card">
            <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
        </div>
        <div class="col-lg-6 content">
            @if (session('success'))
                <div class="alert alert-box alert-dismissible" id="successAlert">
                    <div class="content">
                        <div class="alert-information">
                            <h3>{{ session('success') }}</h3>
                        </div>
                        <div class="body">
                            <div class="product-added">
                                <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
                                <div>
                                    <p class="m-0">{{ $product->name }}</p>
                                    {{-- <p class="m-0">Qty : {{ $product->quantity }}</p> --}}
                                </div>
                            </div>

                            <a href="{{ route('merchandise.cart') }}" class="btn-alert cart">View My Cart</a>
                            <a href="{{ route('merchandise.checkout') }}" class="btn-alert checkout">Checkout</a>
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">continue
                                shopping</button>
                        </div>
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


<script>
    setTimeout(function() {
        var errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            errorAlert.classList.add('fade-out');
            setTimeout(function() {
                errorAlert.style.display = 'none';
            }, 500);
        }
    }, 3000);

    // Menghilangkan alert ketika mengklik di luar area alert
    function closeAlert(event, alertId) {
        var alertElement = document.getElementById(alertId);
        if (alertElement && !alertElement.contains(event.target)) {
            alertElement.style.display = 'none';
        }
    }

    document.addEventListener('click', function(event) {
        closeAlert(event, 'errorAlert');
        closeAlert(event, 'successAlert');
    });
</script>
