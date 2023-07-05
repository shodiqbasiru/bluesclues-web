@extends('merchandise.layouts.main')

@section('content')
<div class="container store-detail">
    <div class="row justify-content-between">

        <div class="col-lg-6 detail-card">
            <img src="{{  asset('storage/' . $merchandise->image) }}" alt="">
        </div>
        <div class="col-lg-6 content">
            <form action="{{ route('addToCart', $merchandise->slug) }}" method="POST">
                @csrf
                <input type="hidden" name="merchandise_id" value="{{ $merchandise->id }}">
                <input type="hidden" name="price" value="{{ $merchandise->price }}">
                <input type="hidden" name="is_available" value="{{ $merchandise->is_available }}">
                <div class="header">
                    
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <h3 class="title">{{ $merchandise->name }}</h3>
                    @if ($merchandise->is_available == 1)
                    <h4><span class="badge bg-success">Available</span></h4>
                    @else
                    <h4><span class="badge bg-danger">Sold Out</span></h4>
                    @endif
                    <h3>Rp {{ number_format($merchandise->price, 0, ',', '.') }}</h3>
                </div>
                @if ($merchandise->is_available == 1)
                <div class="quantity">
                    <label for="quantity-select">Qty:</label>
                    <div class="quantity-control">
                        <button class="decrement">-</button>
                        <input type="number" id="quantity-select" min="1" max="10" value="1" name="quantity-select"
                            readonly>
                        <button class="increment">+</button>
                    </div>
                </div>
                <button type="submit" class="btn-merchan">Add to cart</button>
                @endif
            </form>

            <div class="description">
                {!! $merchandise->description !!}
            </div>
            <div class="noted">
                <p>Note: This product only available to ship in the <br> Jakarta and Malaysia</p>
            </div>

        </div>
    </div>

</div>
<div class="container recommendations-section">
    <div class="row">
        <h1 class="text-center my-4">Product Recommendations</h1>

        @php
        $cardCount = 3; // Jumlah kartu yang ingin ditampilkan
        @endphp

        <div class="content">
            @for ($i = 0; $i < $cardCount; $i++) <a href="">
                <div class="card">
                    <img src="{{ url('./assets/img/bc-1.png') }}" class="card-img-top" alt="...">
                    <button class="btn">Detail</button>
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-price">rp.10.000</p>
                    </div>
                </div>
                </a>
                @endfor
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var incrementButton = document.querySelector('.increment');
        var decrementButton = document.querySelector('.decrement');
        var quantityInput = document.getElementById('quantity-select');
    
        incrementButton.addEventListener('click', function(e) {
            e.preventDefault();
            var currentValue = parseInt(quantityInput.value);
            if (currentValue < 10) {
                quantityInput.value = currentValue + 1;
            }
        });
    
        decrementButton.addEventListener('click', function(e) {
            e.preventDefault();
            var currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    });
</script>
@endsection