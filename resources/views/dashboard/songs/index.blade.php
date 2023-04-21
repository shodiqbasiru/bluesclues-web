@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">All Songs</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
        </button>
    </div>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <a href="/admin/dashboard/songs/create" class="btn btn-outline-light mb-3">Add a song</a>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Song Title</th>
                <th scope="col">Release Date</th>
                <th scope="col">Album</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($news as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($item->release_date)->format('d F Y') }}</td>
                <td>{{ $item->album }}</td>
                <td>
                    <a href="/admin/dashboard/songs/{{ $item->slug }}" class="btn btn-sm btn-outline-light me-2"><span
                            data-feather="eye"></span></a>

                    <a href="/admin/dashboard/songs/{{ $item->slug }}/edit"
                        class="btn btn-sm btn-outline-light me-2"><span data-feather="edit"></span></a>
                    <form action="/admin/dashboard/songs/{{ $item->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light me-2"><span
                                data-feather="trash"></span></button>
                    </form>
                </td>
            </tr>
            @endforeach
        <tbody>
    </table>
</div>
@endsection