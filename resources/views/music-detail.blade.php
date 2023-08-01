@extends('layouts.main')

@section('content-page')
    <div id="detailMusic">

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
                    <p>Released On {{ date('d F Y', strtotime($song->release_date)) }}</p>
                    <p>
                        <a href="{{ $song->link }}" target="blank">Stream/Download</a>
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
        <a href="/music" class="btn btn-musik">Back</a>
    </div>
@endsection
