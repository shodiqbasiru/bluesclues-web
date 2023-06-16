@extends('layouts.main')

@section('content-page')
    <div class="page-music">
        @foreach ($music as $item)
            <div class="song">
                <img src="" alt="">
                <div class="overlay">

                </div>
            </div>
        @endforeach

    </div>
@endsection
