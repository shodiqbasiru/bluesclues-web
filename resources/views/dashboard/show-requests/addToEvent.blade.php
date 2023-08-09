@extends('dashboard.layouts.main')

@section('content')
    <div class="container my-5">
        <a href="/admin/dashboard/show-requests" class="btn btn-transparent me-2">
            <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                    class="me-1"></span> Back to Show Requests</div>
        </a>
        <h1>Add to event</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group my-3">
                <label for="eventname">Event Name:</label>
                <input type="text" class="form-control{{ $errors->has('eventname') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('eventname', $showRequest->eventname) }}" id="eventname" name="eventname" placeholder="Enter event name">
                @if ($errors->has('eventname'))
                    <span class="invalid-feedback">{{ $errors->first('eventname') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="location">Location:</label>
                <input type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('location', $showRequest->location) }}" id="location" name="location" placeholder="Enter location">
                @if ($errors->has('location'))
                    <span class="invalid-feedback">{{ $errors->first('location') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="maps">Maps:</label>
                <input type="text" class="form-control{{ $errors->has('maps') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('maps') }}" id="maps" name="maps" placeholder="Enter maps">
                @if ($errors->has('maps'))
                    <span class="invalid-feedback">{{ $errors->first('maps') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" min="00:00" max="23:59"
                    value="{{ old('time') }}" required>
                @if ($errors->has('time'))
                    <span class="invalid-feedback">{{ $errors->first('time') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="date">Date:</label>
                <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('date', $formattedDate) }}" id="date" name="date" placeholder="Enter date">
                @if ($errors->has('date'))
                    <span class="invalid-feedback">{{ $errors->first('date') }}</span>
                @endif
            </div>
            <div class="form-group my-4">
                <label for="is_free">Is Free</label>
                <select name="is_free" id="is_free"
                    class="form-control{{ $errors->has('is_free') ? ' is-invalid' : '' }}">
                    <option value="1" {{ old('is_free') == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_free') == 0 ? 'selected' : '' }}>No</option>
                </select>
                @if ($errors->has('is_free'))
                    <span class="invalid-feedback">{{ $errors->first('is_free') }}</span>
                @endif
            </div>

            <div class="form-group my-3">
                <label for="more_information">Link for more information:</label>
                <input type="text" class="form-control{{ $errors->has('more_information') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('more_information') }}" id="more_information" name="more_information" placeholder="Enter link">
                @if ($errors->has('more_information'))
                    <span class="invalid-feedback">{{ $errors->first('more_information') }}</span>
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
            <button type="submit" class="btn-primary-dashboard mt-4">Add event</button>
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







