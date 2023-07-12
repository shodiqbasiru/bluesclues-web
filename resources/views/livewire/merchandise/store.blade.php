<div class="container-fluid page-store" id="homeStore">

    {{-- Slider Header --}}
    <div class="slider">
        <div class="swiper sliderStore">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ url('./assets/img/banner-1.png') }}" alt="...">
                </div>
                <div class="swiper-slide">
                    <img src="{{ url('./assets/img/banner-2.png') }}" alt="...">
                </div>
                <div class="swiper-slide">
                    <img src="{{ url('./assets/img/banner-3.png') }}" alt="...">
                </div>
            </div>
        </div>
        <div class="slider-control">
            <div class="swiper-button-prev slider-arrow">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next slider-arrow">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="header">
            <h2>{{ $title }}</h2>
            <a href="{{ route('products') }}" class="btn btn-home">View All <i class="fa fa-angle-right"></i></a>
        </div>
        <div class="body">
            @foreach ($products as $item)
                <a href="{{ route('product.detail', $item->slug) }}">
                    <div class="card">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                            alt="{{ $item->name }}">
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
