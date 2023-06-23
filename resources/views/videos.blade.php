@extends('layouts.main')

@section('content-page')
    <div class="page-video">

        <div id="video-header">
            <div class="header-img">
                <img src="{{ $videos[0]['thumbnail'] }}" alt="{{ $videos[0]['title'] }}" class="video-thumbnail"
                    data-video-id="{{ $videos[0]['id'] }}" id="thumbnail_{{ $videos[0]['id'] }}">
                <img src="{{ url('./assets/img/icons/s-play.png') }}" alt="icon-play" class="btn-play">
            </div>

            <div class="title">
                <h2>{{ $videos[0]['title'] }}</h2>
                <div class="icons">
                    <p>Share</p>
                    <img src="{{ url('./assets/img/icons/circle_fb.svg') }}" alt="">
                    <img src="{{ url('./assets/img/icons/circle_twit.svg') }}" alt="">
                    <img src="{{ url('./assets/img/icons/circle_google.svg') }}" alt="">
                    <img src="{{ url('./assets/img/icons/circle_t.svg') }}" alt="">
                    <img src="{{ url('./assets/img/icons/circle_insta.svg') }}" alt="">
                </div>
            </div>

        </div>

        @livewire('contents')

        <div id="video-container" style="display:none">
            <div class="video-wrapper">
                <button id="close-button" class="close-btn">&#x2716;</button>
                <iframe id="video-player" width="560" height="315" src="" frameborder="0"
                    allowfullscreen></iframe>
            </div>
        </div>


    </div>
@endsection
