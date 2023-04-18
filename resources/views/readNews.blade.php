@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">

            <h1>{{ $news->title }}</h1>
            <p>
                <small class="text-muted">
                    {{ $news->created_at->diffForHumans() }}
                </small>
            </p>
            <img src="https://source.unsplash.com/1200x400?music " alt="image" class="img-fluid">

            <article class="mb-5 mt-5">
                {!! $news->content !!}
            </article>
            <p><a href="/news">Kembali ke News</a></p>
        </div>

    </div>

</div>



@endsection