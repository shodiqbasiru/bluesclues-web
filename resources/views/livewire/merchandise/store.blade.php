<div class="container-fluid page-store">

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

    {{-- @php
        $cardCount = 12; 
    @endphp --}}
    <div class="content">
        <div class="header">
            <h2>{{ $title }}</h2>
            <div class="input-group">
                <input wire:model="search" type="text" class="form-control" placeholder="Search . . ."
                    aria-label="Search" aria-describedby="basic-addon1">
                <span class="input-group-text" id="basic-addon1">
                    <ion-icon name="search"></ion-icon>
                </span>
            </div>
        </div>
        <div class="body">
            @foreach ($products as $item)
                {{-- @for ($i = 0; $i < $cardCount; $i++) --}}
                <a href="/store/detail">
                    <div class="card">
                        <img src="{{ url('./assets/img/bc-1.png') }}" class="card-img-top" alt="...">
                        <button class="btn">Detail</button>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-price">rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
                {{-- @endfor --}}
            @endforeach
        </div>
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>


</div>
