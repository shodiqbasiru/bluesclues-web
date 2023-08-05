@extends('dashboard.layouts.main')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        <div></div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">User Accounts</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>a
    @endif
    <div class="d-flex justify-content-between">
        <div>
            <form action="{{ route('user.index', ['status' => $status ?? '']) }}" method="GET">
                <div class="btn-group" role="group" aria-label="Filter user">
                    <button type="submit" name="status" value="unverified"
                        class="btn btn-outline-light mb-3{{ $status === 'unverified' ? ' active' : '' }}">Unverified</button>
                    </button>
                    <button type="submit" name="status" value="verified"
                        class="btn btn-outline-light mb-3{{ $status === 'verified' ? ' active' : '' }}">Verified</button>
                </div>
            </form>
        </div>
        <form action="{{ route('user.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search user accounts"
                    value="{{ $searchQuery ?? '' }}">
                <button type="submit" class="btn-filter-dashboard"><i class="fas fa-search"></i></button>

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
                    <th scope="col">Email Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td class="align-middle">{{ $startIndex + $loop->index }}</td>
                        <td class="align-middle" style="max-width: 300px;">{{ $item->name }}</td>
                        <td class="align-middle" style="max-width: 400px;">{{ $item->email }}</td>
                        <td class="align-middle">
                            @if ($item->email_verified_at)
                                <span class="text-success">Verified</span>
                            @else
                                <span class="text-danger">Unverified</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
