@extends('dashboard.layouts.main')

@section('content')
<div class="container mb-3 border-bottom pt-3 pb-2">
    <div class="row">
        <div class="col-md-6">
            <h1 class="h2">Dashboard</h1>
        </div>
        <div class="col-md-6 text-end">
            <span class="text">Quick Actions:</span>
            <div class="btn-group" role="group" aria-label="Quick Actions">
                <a href="/admin/dashboard/news/create" class="btn btn-sm btn-outline-light">Create News</a>
                <a href="/admin/dashboard/events/create" class="btn btn-sm btn-outline-light">Add Event</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-6">
            <a href="/admin/dashboard/orders?status=checking-payment" class="text-decoration-none">
                <div class="card btn btn-lg btn-outline-light">
                    <div class="card-body">Orders to Check</div>
                    <div class="card-body">
                        <h1>{{ $ordersToCheck }}</h1>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="/admin/dashboard/show-requests?status=awaiting-approval" class="text-decoration-none">
                <div class="card btn btn-lg btn-outline-light">
                    <div class="card-body">Awaiting Approval Show Requests</div>
                    <div class="card-body">
                        <h1>{{ $awaitingApprovalRequests }}</h1>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h1>{{ $totalUsers }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total Orders</div>
                <div class="card-body">
                    <h1>{{ $totalOrders }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total Merchandise</div>
                <div class="card-body">
                    <h1>{{ $totalMerchandise }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total News</div>
                <div class="card-body">
                    <h1>{{ $totalNews }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Near Events</div>
                <div class="card-body">
                    <ul>
                        @foreach ($nearEvents as $event)
                        <li>
                            {{ $event->eventname }} - <strong>{{ \Illuminate\Support\Carbon::parse($event->date)->format('d F Y') }}</strong>
                            <a href="/admin/dashboard/events/{{ $event->slug }}" class="btn btn-sm btn-outline-light me-2">View</a>
                        </li>
                        @endforeach
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
