@extends('layouts.main')

@section('content-page')
<div class="container-fluid d-news">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
    
            {{-- <p>Share : 
                <img src="" alt="">
            </p> --}}
        
            <a href="/news" class="btn btn-home text-center">Back</a>

        </div>
    </div>
</div>
@endsection