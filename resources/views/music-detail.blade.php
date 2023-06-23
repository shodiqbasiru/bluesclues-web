@extends('layouts.main')

@section('content-page')
    <div class="d-music">
        <div class="content">
            <div class="lyrics">
                <h1 class="text-center">{{ $song->title }}</h1>
                <div class="music">
                    {!! $song->lyrics !!}
                </div>
            </div>
            <div class="thumbnail">
                <img src="{{ asset('storage/' . $song->image) }}" alt="image">
                <p>Release {{ $song->release_date }}</p>
                <p>Go To :
                    <a href="{{ $song->spotify_link }}" target="blank">Spotify</a>
                    <a href="{{ $song->youtube_link }}" target="blank">Youtube</a>
                </p>
            </div>
        </div>
    </div>
    <div class="other-songs">
        @foreach ($songs as $item)
            @if ($item->id !== $song->id)
                <div class="song">
                    <a href="/music/{{ $item->slug }}" class="song-detail">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="">
                        <div class="overlay">
                            <h5>{{ $item->title }}</h5>
                            <h5>Info</h5>
                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
    <a href="/music" class="btn btn-home btn-musik">Back</a>
@endsection
