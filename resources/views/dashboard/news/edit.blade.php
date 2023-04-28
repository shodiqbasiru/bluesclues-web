@extends('dashboard.layouts.main')

@section('content')

<div class="container my-5">
    <a href="/admin/dashboard/news" class="btn btn-transparent me-2">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                class="me-1"></span> Back to News</div>
    </a>
    <h1>Edit news</h1>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('news.update', $news->slug) }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="form-group my-4">
            <label for="title">Title</label>
            <input type="text" name="title" id="title"
                class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('title', $news->title) }}">
            @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <img class="img-preview img-fluid mb-3 col-sm-5">
            <input class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" type="file" id="image"
                name="image" onchange="previewImage()">
            @if ($errors->has('image'))
            <span class="invalid-feedback">{{ $errors->first('image') }}</span>
            @endif
        </div>
        <div class="form-group my-4">

            <label class="mb-2" for="content">Content</label>

            <textarea name="content" id="content"
                class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ old('content', $news->content) }}</textarea>
            @if ($errors->has('content'))
            <span class="invalid-feedback">{{ $errors->first('content') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-outline-light">Save</button>
    </form>
</div>


<script>
    function previewImage(){
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');
    
        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection