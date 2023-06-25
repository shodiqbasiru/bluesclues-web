@extends('layouts.main')

@section('content-page')
    <div class="container-fluid d-news">
        <div class="content">
            <h2>News</h2>
            <h1 class="text-center">{{ $news->title }}</h1>

            @if ($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" alt="image" class="img-fluid">
            @else
                <img src="https://source.unsplash.com/400x400?music " alt="image" class="img-fluid">
            @endif

            <div class="news">
                {!! $news->content !!}
            </div>
        </div>

        <div class="share-icons">
            <p>Share :</p>
            <a href="#"><img src="{{ url('./assets/img/icons/icon-facebook.png') }}" alt=""></a>
            <a href="#"><img src="{{ url('./assets/img/icons/icon-instagram.png') }}" alt=""></a>
            <a href="#"><img src="{{ url('./assets/img/icons/icon-twitter.png') }}" alt=""></a>
            <a href="#"><img src="{{ url('./assets/img/icons/icon-whatsapp.png') }}" alt=""></a>
        </div>

        <a href="/news" class="btn btn-home">Back</a>
    </div>
@endsection
