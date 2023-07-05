@extends('merchandise.layouts.main')

@section('content')
    <div class="container-fluid page-store">
        <div class="filter" id="filter">
            <a href="{{ route('store.index') }}"><button>All</button></a> <!-- Display the "All" category -->
            @foreach ($merchCategories as $category)
                <a href="{{ route('store.index', ['category' => $category->slug]) }}"><button>{{ $category->name }}</button></a>
            @endforeach
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

        <div class="content">
            @foreach ($merchandise as $item)
                <a href="/store/detail/{{ $item->slug }}">
                    <div class="card">
                        <img src="{{  asset('storage/' . $item->image) }}" class="card-img-top" alt="...">
                        <button class="btn">Detail</button>
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $item->name }}
                            </h5>
                            <p class="card-price">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
