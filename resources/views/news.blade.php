@extends('layouts.main')

@section('content-page')
    <div class="container-fluid page-news">
        <h2>News</h2>
        @livewire('news-contents')
    </div>
@endsection
