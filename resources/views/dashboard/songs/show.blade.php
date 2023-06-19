@extends('dashboard.layouts.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="d-flex justify-content-center mt-5">
                    <a href="/admin/dashboard/songs" class="btn btn-transparent me-2 mb-2">
                        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                                class="me-1"></span> Back to Songs</div>
                    </a>
                </div>
                <div class="d-flex justify-content-center">

                    <a href="/admin/dashboard/songs/{{ $song->slug }}/edit" class="btn btn-outline-light me-2">
                        <div class="d-flex justify-content-center align-items-center"><span data-feather="edit"
                                class="me-1"></span>
                            Edit</div>
                    </a>
                    <form action="/admin/dashboard/songs/{{ $song->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-light me-2">
                            <div class="d-flex justify-content-center align-items-center"
                                onclick="return confirm ('Are you sure to delete this entry?')"><span
                                    data-feather="trash" class="me-1"></span>
                                Delete</div>
                        </button>
                    </form>
                </div>

                @if ($song->image)
                <div class="d-flex justify-content-center mt-5">
                    <img src="{{ asset('storage/' . $song->image) }}" alt="image" class="img-fluid w-75">
                </div>
                @endif
                <div class="mx-auto mt-5 text-center">
                    <h1 class=" mb-4">{{ $song->title }}</h1>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Album</th>
                                <td>{{ $song->album }}</td>
                            </tr>
                            <tr>
                                <th>Release Date</th>
                                <td>{{ \Illuminate\Support\Carbon::parse($song->release_date)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Spotify Link</th>
                                <td><a href="{{  $song->spotify_link }}" target="_blank">{{ $song->spotify_link }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Youtube Link</th>
                                <td><a href="{{  $song->youtube_link }}" target="_blank">{{ $song->youtube_link }}</a>
                                </td>
                            </tr>

                        <tbody>
                    </table>
                </div>
                <div class="mx-auto mt-5">
                    <h5 class=" mb-4">Lyrics:</h5>
                </div>

                <article class="mb-5 mt-5">
                    {!! $song->lyrics !!}
                </article>
            </div>
        </div>
    </div>
</div>
@endsection