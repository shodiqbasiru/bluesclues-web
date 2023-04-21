@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">All News</h1>
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
    <a href="/admin/dashboard/news/create" class="btn btn-outline-light mb-3">Create a news</a>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Published at</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($news as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="max-width: 550px;">{{ $item->title }}</td>
                <td>{{ $item->created_at->format('d F Y') }}</td>
                <td>
                    <a href="/admin/dashboard/news/{{ $item->slug }}" class="btn btn-sm btn-outline-light me-2"><span
                            data-feather="eye"></span></a>

                    <a href="/admin/dashboard/news/{{ $item->slug }}/edit"
                        class="btn btn-sm btn-outline-light me-2"><span data-feather="edit"></span></a>
                    <form action="/admin/dashboard/news/{{ $item->id }}" method="post" class="d-inline">
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