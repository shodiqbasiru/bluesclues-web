@extends('layouts.main')

@section('content')

<div class="container">
    <h1>Tambah Berita</h1>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('news.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title"
                class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
            @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group">

            <label for="content">Content</label>

            <textarea name="content" id="content"
                class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ old('content') }}</textarea>
            @if ($errors->has('content'))
            <span class="invalid-feedback">{{ $errors->first('content') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Add News</button>
    </form>
</div>

@endsection