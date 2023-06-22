@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">All Messages</h1>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="table-responsive">

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Subject</th>
                <th scope="col">WhatsApp</th>
                <th scope="col">Created at</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($message as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="max-width: 100px;">{{ $item->name }}</td>
                <td style="max-width: 100px;">{{ $item->email }}</td>
                <td style="max-width: 100px;">{{ $item->subject }}</td>
                <td>{{ $item->whatsapp }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($item->date)->format('d F Y') }}</td>
                <td>
                    <a href="/admin/dashboard/messages/{{ $item->id }}" class="btn btn-sm btn-outline-light me-2"><span
                            data-feather="eye"></span></a>
                    <form action="/admin/dashboard/messages/{{ $item->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light me-2"
                            onclick="return confirm ('Are you sure to delete this message?')"><span
                                data-feather="trash"></span></button>
                    </form>
                </td>
            </tr>
            @endforeach
            {{ $message->links() }}
        <tbody>
    </table>
</div>

<script>


</script>
@endsection