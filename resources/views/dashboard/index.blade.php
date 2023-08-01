@extends('dashboard.layouts.main')

@section('content')
    <div class="container mb-3 border-bottom pt-3 pb-2">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h2">Dashboard</h1>
            </div>
        </div>
    </div>
    <div class="container dashboard-home">
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <a href="/admin/dashboard/orders?status=checking-payment" class="text-decoration-none">
                    <div class="card card-dashboard">
                        <div class="card-content">
                            <h4>Orders to Check</h4>
                            <p>Last {{ $latestOrderDays }} days</p>
                            <h1>{{ $ordersToCheck }}</h1>
                        </div>
                        <div class="card-logo">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="/admin/dashboard/show-requests?status=awaiting-approval" class="text-decoration-none">
                    <div class="card card-dashboard">
                        <div class="card-content">
                            <h4>Waiting for approval</h4>
                            <p>Last {{ $latestApprovalRequestDays }} days</p>
                            <h1>{{ $awaitingApprovalRequests }}</h1>
                        </div>
                        <div class="card-logo">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-dashboard">
                    <div class="card-content">
                        <h4>Total Orders</h4>
                        <p>Last {{ $latestOrderDays }} days</p>

                        <h1>{{ $totalOrders }}</h1>
                    </div>
                    <div class="card-logo">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card card-dashboard">
                    <div class="card-content">
                        <h4>Total Users</h4>
                        <p>Last {{ $latestUserDays }} days</p>
                        <h1>{{ $totalUsers }}</h1>
                    </div>
                    <div class="card-logo">
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-dashboard">
                    <div class="card-content">
                        <h4>Total Merchandise</h4>
                        <p>Last {{ $latestMerchandiseDays }} days</p>
                        <h1>{{ $totalMerchandise }}</h1>
                    </div>
                    <div class="card-logo">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-dashboard">
                    <div class="card-content">
                        <h4>Total News</h4>
                        <p>Last {{ $latestNewsDays }} days</p>
                        <h1>{{ $totalNews }}</h1>
                    </div>
                    <div class="card-logo">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-5">
            <div class="col-md-12">
                <div class="card table-events">
                    <div class="card-header">
                        <h4>Near Events</h4>
                        <a class="nav-link " href="/admin/dashboard/events">View All</a>
                    </div>
                    <div class="card-content">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nearEvents as $event)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->eventname }}</td>
                                        <td>{{ $event->created_at->format('d F Y') }}</td>
                                        <td>
                                            <a href="/admin/dashboard/events/{{ $event->slug }}"
                                                class="text-decoration-none">View Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
