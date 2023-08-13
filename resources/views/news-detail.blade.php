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

        <div class="d-flex justify-content-between">
            <div>
                <p>
                    <i class="fas fa-eye"></i>
                    @if (!empty($news->viewers))
                        {{ $news->viewers }}
                    @else
                        0
                    @endif
                    viewers
                </p>
            </div>
            <div class="share-icons">
                <p>Share :</p>

                @foreach ($shareLinks as $platform => $link)
                    <a href="{{ $link }}" target="_blank" target="_blank"
                        onclick="openSmallWindow(event, '{{ $link }}')"><img
                            src="{{ url('./assets/img/icons/icon-' . $platform . '.png') }}" alt=""></a>
                @endforeach
            </div>
        </div>

        <a href="/news" class="btn btn-home">Back</a>
    </div>
@endsection
