<div class="container-fluid page-store">

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

    @php
        $cardCount = 12; // Jumlah kartu yang ingin ditampilkan
    @endphp

    <div class="content">
        @for ($i = 0; $i < $cardCount; $i++)
            <a href="/store/detail">
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
