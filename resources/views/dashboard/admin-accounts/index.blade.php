@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <div></div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
    <h1 class="h2">Admin Accounts</h1>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->has('error'))
<div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
    {{ $errors->first('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between mt-3">
    <div>
        <a href="{{ route('admin.edit') }}" class="btn-primary-dashboard mb-3">Account Settings</a>
        @if (Auth::guard('admin')->user()->id == 1)
        <a href="{{ route('admin.create') }}" class="btn-primary-dashboard mb-3"><i class="fas fa-circle-plus"></i>
            Add an admin account</a>
        @endif
        

    </div>
    <form action="{{ route('admin.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search admin accounts"
                value="{{ $searchQuery ?? '' }}">
            <span class="input-group-text search-dashboard">
                <i class="fas fa-search"></i>
            </span>
        </div>
    </form>
</div>
<div class="table-responsive">
    @if ($searchQuery)
    <div class="mb-3">
        <h5>Results for: "{{ $searchQuery }}"</h5>
    </div>
    @endif
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                @if (Auth::guard('admin')->user()->id == 1)
                <th scope="col">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $item)
            <tr>
                <td class="align-middle">{{ $startIndex + $loop->index }}</td>
                <td class="align-middle" style="max-width: 300px;">{{ $item->name }}</td>
                <td class="align-middle" style="max-width: 400px;">
                    {{ $item->email }}
                    @if ($item->id == Auth::guard('admin')->user()->id)
                    <span class="badge bg-primary">You</span>
                    @endif
                    @if ($item->id == 1)
                    <span class="badge bg-primary">Super Admin</span>
                    @endif
                </td>
                @if (Auth::guard('admin')->user()->id == 1)
                <td class="align-middle">
                    <form action="/admin/dashboard/admins/{{ $item->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn-action-dashboard btn-sm me-2"
                            onclick="return confirm ('Are you sure to delete this account?')">
                            @if ($item->id == 1)
                            <i class="fas fa-trash" style="color: #999999;"></i>
                            @else
                            <i class="fas fa-trash"></i>
                            @endif
                        </button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $admins->links() }}
</div>
@endsection