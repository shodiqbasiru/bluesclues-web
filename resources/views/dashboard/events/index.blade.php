@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">All Events</h1>

</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <a href="/admin/dashboard/events/create" class="btn btn-outline-light mb-3">Add an event</a>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Event Name</th>
                <th scope="col">Location</th>
                <th scope="col">Time</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $item)
            <tr>
                <td>{{ $startIndex + $loop->index }}</td>
                <td>{{ $item->eventname }}</td>
                <td style="max-width: 550px;">{{ $item->location }}</td>
                <td>{{ $item->time }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($item->date)->format('d F Y') }}</td>
                <td>
                    <a href="/admin/dashboard/events/{{ $item->slug }}" class="btn btn-sm btn-outline-light me-2"><span
                            data-feather="eye"></span></a>

                    <a href="/admin/dashboard/events/{{ $item->slug }}/edit"
                        class="btn btn-sm btn-outline-light me-2"><span data-feather="edit"></span></a>
                    <form action="/admin/dashboard/events/{{ $item->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light me-2"
                            onclick="return confirm ('Are you sure to delete this entry?')"><span
                                data-feather="trash"></span></button>
                    </form>
                </td>
            </tr>
            @endforeach
        <tbody>
            {{ $events->links() }}
    </table>
</div>
@endsection