@extends('dashboard.layouts.main')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Songs</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="table-responsive">
        <div class="d-flex justify-content-between">
            <a href="/admin/dashboard/songs/create" class="btn-primary-dashboard mb-3"><i class="fas fa-circle-plus"></i>
                Add a song</a>
            <form action="{{ route('songs.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search songs"
                        value="{{ $searchQuery ?? '' }}">
                    <button type="submit" class="btn-filter-dashboard"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        @if ($searchQuery)
            <div class="mb-3">
                <h5>Results for: "{{ $searchQuery }}"</h5>
            </div>
        @endif
        <table class="table table-sm">
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
                @foreach ($songs as $item)
                    <tr>
                        <td>{{ $startIndex + $loop->index }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($item->release_date)->format('d F Y') }}</td>
                        <td>{{ $item->album }}</td>
                        <td>
                            <a href="/admin/dashboard/songs/{{ $item->slug }}" class="btn-action-dashboard me-2"><i
                                    class="fas fa-eye"></i></a>

                            <a href="/admin/dashboard/songs/{{ $item->slug }}/edit" class="btn-action-dashboard me-2"><i
                                    class="fas fa-edit"></i></a>
                            <form action="/admin/dashboard/songs/{{ $item->slug }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn-action-dashboard me-2"
                                    onclick="return confirm ('Are you sure to delete this entry?')"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            <tbody>
        </table>
        {{ $songs->links() }}
    </div>
@endsection
