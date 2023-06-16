@extends('layouts.main')

@section('hero')
    {{-- hero section --}}
    <div class="container-fluid bg-hero">
        <div class="logo">
            <img src="{{ url('./assets/img/icons/logo-blues.png') }}" alt="">
        </div>
        <div class="coming-soon">
            <h2>New Single</h2>
            <h1>New Available</h1>
        </div>
    </div>
@endsection

@section('h-music')
    <div class="container-fluid h-music slider" id="h-music">
        <div class="bg-music"></div>
        <div class="card">
            <img src="{{ url('./assets/img/about/single-3.png') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Mangsa ka Mangsa</h5>
                <p class="card-text">The New Single, Out Now</p>
                <a href="#" class="btn btn-home">Listen Now</a>
                <a href="#" class="btn btn-home">All Music</a>
            </div>
        </div>

    </div>
@endsection

@section('h-videos')
    <div class="container-fluid h-videos" id="h-videos">

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="box">
                        <swiper-slide lazy="true">
                            <iframe src="https://www.youtube.com/embed/8oRiz8bbq-I"></iframe>
                        </swiper-slide>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="box">
                        <swiper-slide lazy="true">
                            <iframe src="https://www.youtube.com/embed/85fqpyvsCdg"></iframe>
                        </swiper-slide>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="box">
                        <swiper-slide lazy="true">
                            <iframe src="https://www.youtube.com/embed/85fqpyvsCdg"></iframe>
                        </swiper-slide>
                    </div>
                </div>
            </div>
            <div class="slider-control">
                <div class="swiper-button-prev slider-arrow">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                </div>
                <div class="swiper-button-next slider-arrow">
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <a href="#" class="btn btn-home mb-4">All videos</a>
    </div>
@endsection

@section('h-merchan')
    <div class="container-fluid h-merchan" id="h-merchan">

        <div class="merch-container">
            <h3>Show your support for <span>blues clues </span><br>with our exclusive merchandise <br>collection.</h2>
        </div>
        <div class="p-merch">
            <a href="#" class="btn btn-home">All Items</a>
            <div class="m-card">
                <div class="card-merch">
                    <div class="head">
                        <img src="{{ url('/assets/img/jaket_1.png') }}" alt="">
                    </div>
                    <div class="body">
                        <p class="name">Crewnack Jacket</p>
                        <p class="price">Rp. 50.000</p>
                    </div>
                </div>
                <div class="card-merch">
                    <div class="head">
                        <img src="{{ url('/assets/img/jaket_1.png') }}" alt="">
                    </div>
                    <div class="body">
                        <p class="name">Crewnack Jacket</p>
                        <p class="price">Rp. 50.000</p>
                    </div>
                </div>
                <div class="card-merch">
                    <div class="head">
                        <img src="{{ url('/assets/img/jaket_1.png') }}" alt="">
                    </div>
                    <div class="body">
                        <p class="name">Crewnack Jacket</p>
                        <p class="price">Rp. 50.000</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('h-news')
    <div class="container-fluid h-news" id="h-news">
        <h2>News</h2>
        <div class="news">
            @foreach ($news as $newsitem)
                <div class="card-news">

                    @if ($newsitem->image)
                        <img src="{{ asset('storage/' . $newsitem->image) }}" alt="image" class="img-fluid">
                    @else
                        <img src="https://source.unsplash.com/400x400?music " alt="image" class="img-fluid">
                    @endif

                    <h3><a href="/news/{{ $newsitem->slug }}" class="text-decoration-none"> {{ $newsitem->title }}</a></h3>
                    <p>
                        <small class="text-muted">
                            {{ $newsitem->created_at->diffForHumans() }}
                        </small>
                    </p>

                    {{ $newsitem->excerpt }}

                    <a href="/news/{{ $newsitem->slug }}" class="text-decoration-none">Read More</a>
                </div>
            @endforeach
        </div>

        <a href="/news" class="btn btn-home">All news</a>
    </div>
@endsection
