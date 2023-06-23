@extends('merchandise.layouts.main')

@section('content')
    <div class="container store-detail">
        <div class="row justify-content-between">
            <div class="col-lg-6 detail-card">
                <img src="{{ url('./assets/img/bc-3.png') }}" alt="">
            </div>
            <div class="col-lg-6 content">
                <div class="header">
                    <h3 class="title">Blues Clues Hoodie</h3>
                    <h3>Rp 150.000</h3>
                </div>
                <div class="product-size">
                    <label for="size-select">Size <span>*</span></label>
                    <div class="size-options">
                        <input type="radio" id="size-small" name="size" value="small">
                        <label for="size-small">S</label>
                        <input type="radio" id="size-medium" name="size" value="medium">
                        <label for="size-medium">M</label>
                        <input type="radio" id="size-large" name="size" value="large">
                        <label for="size-large">L</label>
                        <input type="radio" id="size-xlarge" name="size" value="xlarge">
                        <label for="size-xlarge">XL</label>
                    </div>
                </div>
                <div class="quantity">
                    <label for="quantity-select">Qty:</label>
                    <div class="quantity-control">
                        <button class="decrement">-</button>
                        <input type="number" id="quantity-select" min="1" value="1">
                        <button class="increment">+</button>
                    </div>
                </div>
                <button type="submit" class="btn-merchan">Add to cart</button>
                <div class="description">
                    <p>Introducing our "Mountain Sunrise" t-shirt - a soft and lightweight blend of 60% cotton and 40%
                        polyester, with a vibrant screen print design of a mountain range at sunrise. The relaxed fit is
                        perfect for everyday wear, and our size chart will help you find the perfect fit. Wash in cold water
                        and tumble dry on low heat to keep your t-shirt looking great. Order now and experience the quality
                        and style for yourself.</p>
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
                @for ($i = 0; $i < $cardCount; $i++)
                    <a href="">
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
@endsection
