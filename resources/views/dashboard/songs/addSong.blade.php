@extends('dashboard.layouts.main')

@section('content')


<div class="container my-5">
    <h1>Add song</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('songs.store') }}">
        @csrf
        <div class="form-group my-3">
            <label for="title">Song Title:</label>
            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} mt-2" value="{{ old('title') }}" id="title" name="title" placeholder="Enter song title" >
            @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="album">Album:</label>
            <input type="text" class="form-control{{ $errors->has('album') ? ' is-invalid' : '' }} mt-2" value="{{ old('album') }}" id="album" name="album" placeholder="Enter album" >
            @if ($errors->has('album'))
            <span class="invalid-feedback">{{ $errors->first('album') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="spotify_link">Spotify Link:</label>
            <input type="text" class="form-control{{ $errors->has('spotify_link') ? ' is-invalid' : '' }} mt-2" value="{{ old('spotify_link') }}" id="spotify_link" name="spotify_link" placeholder="Enter spotify link of the song" >
            @if ($errors->has('spotify_link'))
            <span class="invalid-feedback">{{ $errors->first('spotify_link') }}</span>
            @endif
        </div>

        <div class="form-group my-3">
            <label for="youtube_link">Youtube Link:</label>
            <input type="text" class="form-control{{ $errors->has('youtube_link') ? ' is-invalid' : '' }} mt-2" value="{{ old('youtube_link') }}" id="youtube_link" name="youtube_link" placeholder="Enter youtube link of the song" >
            @if ($errors->has('youtube_link'))
            <span class="invalid-feedback">{{ $errors->first('youtube_links') }}</span>
            @endif
        </div>
        
        
        <div class="form-group my-3">
            <label for="release_date">Release date:</label>
            <input type="date" class="form-control{{ $errors->has('release_date') ? ' is-invalid' : '' }} mt-2" value="{{ old('release_date') }}" id="release_date" name="release_date" placeholder="Enter release date" >
            @if ($errors->has('release_date'))
            <span class="invalid-feedback">{{ $errors->first('release_date') }}</span>
            @endif
        </div>
        <div class="form-group my-4">

            <label class="mb-2" for="content">Lyrics:</label>

            <textarea name="content" id="content"
                class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ old('content') }}</textarea>
            @if ($errors->has('content'))
            <span class="invalid-feedback">{{ $errors->first('content') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-outline-light mt-4">Submit</button>
    </form>
</div>          
@endsection



