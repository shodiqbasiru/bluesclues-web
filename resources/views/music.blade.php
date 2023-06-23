@extends('layouts.main')

@section('content-page')
    <div class="page-music">
        @foreach ($music as $item)
            <div class="song">
                <a href="/music/{{ $item->slug }}" class="song-detail">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="">
                    <div class="overlay">
                        <h5>{{ $item->title }}</h5>
                        <h5>Info</h5>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
@endsection
