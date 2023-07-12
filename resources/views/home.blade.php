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
                <a href="{{ route('music') }}" class="btn btn-home">All Music</a>
            </div>
        </div>

    </div>
@endsection

@section('h-videos')
    <div class="h-videos" id="h-videos">

        <div class="swiper sliderHome">
            <div class="swiper-wrapper">
                @foreach ($videos->take(5) as $video)
                    <div class="swiper-slide">
                        <div class="video">
                            <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" class="video-thumbnail">
                            <div class="overlay" data-video-id="{{ $video['id'] }}" data-title="{{ $video['title'] }}"
                                id="thumbnail_{{ $video['id'] }}">
                                <h5 class="mt-5">{{ $video['title'] }}</h5>
                                <h5>Watch</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="slider-control">
            <div class="swiper-button-prev slider-arrow">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </div>
            <div class="video-title"></div>
            <div class="swiper-button-next slider-arrow">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </div>
        </div>


        <a href="/videos" class="btn btn-home">All videos</a>
        <div id="video-container" style="display:none">
            <div class="video-wrapper">
                <button id="close-button" class="close-btn">&#x2716;</button>
                <iframe id="video-player" width="560" height="315" src="" frameborder="0"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection

@section('h-merchan')
    <div class="container-fluid h-merchan" id="h-merchan">

        <div class="merch-container">
            <h3>Show your support for <span>blues clues </span><br>with our exclusive merchandise <br>collection.</h2>
        </div>
        <div class="p-merch">
            <a href="{{ route('products') }}" class="btn btn-home">All Items</a>
            <div class="m-card">
                @foreach ($products as $product)
                    <div class="card-merch">
                        <div class="head">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="">
                        </div>
                        <div class="body">
                            <p class="name">{{ $product->name }}</p>
                            <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
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

                    <h3><a href="/news/{{ $newsitem->slug }}" class="text-decoration-none"> {{ $newsitem->title }}</a>
                    </h3>
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
