@extends('layouts.main')

@section('content')
<div class="container-fluid h-news" id="h-news">
    <div class="blur-img"></div>
    <h2>News</h2>
    <div class="news">
        @foreach ($news as $newsitem)
        <div class="card-news">

            @if ($newsitem->image)
            <img src="{{ asset('storage/' . $newsitem->image) }}" alt="image" class="img-fluid">
            @else
            <img src="https://source.unsplash.com/400x400?music " alt="image" class="img-fluid">

            @endif

            <h3><a href="/news/{{ $newsitem->slug }}" class="text-decoration-none"> {{ $newsitem->title
                    }}</a></h3>
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
</div>
@endsection