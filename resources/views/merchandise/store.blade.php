@extends('merchandise.layouts.main')

@section('content')
    <div class="container-fluid page-store">
        <div class="filter" id="filter">
            <button>Apparel</button>
            <button>Music</button>
            <button>Accessories</button>
        </div>
        <div class="slider">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="3000">
                        <img src="{{ url('./assets/img/banner-1.png') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="{{ url('./assets/img/banner-2.png') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="{{ url('./assets/img/banner-3.png') }}" class="d-block w-100" alt="...">
                    </div>
                </div>
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="0"
                        class="circle active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="1" class="circle"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="2" class="circle"
                        aria-label="Slide 3"></button>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
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
@endsection
