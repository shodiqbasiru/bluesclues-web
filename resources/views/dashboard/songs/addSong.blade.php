@extends('dashboard.layouts.main')

@section('content')
    <div class="container my-5">
        <a href="/admin/dashboard/songs" class="btn btn-transparent me-2">
            <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                    class="me-1"></span> Back to Songs</div>
        </a>
        <h1>Add song</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('songs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group my-3">
                <label for="title">Song Title:</label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('title') }}" id="title" name="title" placeholder="Enter song title">
                @if ($errors->has('title'))
                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="album">Album:</label>
                <input type="text" class="form-control{{ $errors->has('album') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('album') }}" id="album" name="album" placeholder="Enter album">
                @if ($errors->has('album'))
                    <span class="invalid-feedback">{{ $errors->first('album') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="link">Link:</label>
                <input type="text" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('link') }}" id="link" name="link" placeholder="Enter link of the song">
                @if ($errors->has('link'))
                    <span class="invalid-feedback">{{ $errors->first('link') }}</span>
                @endif
            </div>


            <div class="form-group my-3">
                <label for="release_date">Release date:</label>
                <input type="date" class="form-control{{ $errors->has('release_date') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('release_date') }}" id="release_date" name="release_date"
                    placeholder="Enter release date">
                @if ($errors->has('release_date'))
                    <span class="invalid-feedback">{{ $errors->first('release_date') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload song art</label>
                <img class="img-preview img-fluid mb-3 col-sm-5">
                <input class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" type="file" id="image"
                    name="image" onchange="previewImage()">
                @if ($errors->has('image'))
                    <span class="invalid-feedback">{{ $errors->first('image') }}</span>
                @endif
            </div>
            <div class="form-group my-4">

                <label class="mb-2" for="content">Lyrics:</label>

                <textarea name="content" id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ old('content') }}</textarea>
                @if ($errors->has('content'))
                    <span class="invalid-feedback">{{ $errors->first('content') }}</span>
                @endif
            </div>
            <button type="submit" class="btn-primary-dashboard mt-4">Add song</button>
        </form>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
