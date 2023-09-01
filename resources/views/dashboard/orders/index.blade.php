@extends('dashboard.layouts.main')
@section('content')
    <div class="d-flex justify-content-between border-bottom mb-3 flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        <h1 class="h2">Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form action="{{ route('order.export') }}" method="GET">
                <div class="mx-2">
                    @if ($status)
                        <input type="hidden" name="status" value="{{ $status ?? '' }}">
                    @endif
                    @if ($month)
                        <input type="hidden" name="month" value="{{ $month ?? '' }}">
                    @endif
                    @if ($selectedYear)
                        <input type="hidden" name="year" value="{{ $selectedYear ?? '' }}">
                    @endif
                    @if ($selectedYearOnly)
                        <input type="hidden" name="yearonly" value="{{ $selectedYearOnly ?? '' }}">
                    @endif
                    <button type="submit" class="btn-primary-dashboard">Export</button>
                </div>
            </form>
        </div>
    </div>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between">
        <form action="{{ route('order.index') }}" method="GET" style="margin-right: 24px">
            <div class="btn-group btn-no-space mb-3" role="group" aria-label="Filter Orders">
                <button type="button" class="btn-primary-dashboard dropdown-toggle" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $status ? ucfirst($status) : 'Filter By Status' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item{{ empty($status) ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => '']) }}">All</a>
                    <a class="dropdown-item{{ $status === 'waiting-for-payment' ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => 'waiting-for-payment']) }}">Waiting For Payment</a>
                    <a class="dropdown-item{{ $status === 'checking-payment' ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => 'checking-payment']) }}">Checking Payment</a>
                    <a class="dropdown-item{{ $status === 'success' ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => 'success']) }}">Payment Success</a>
                    <a class="dropdown-item{{ $status === 'cancelled' ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => 'cancelled']) }}">Cancelled</a>
                    <a class="dropdown-item{{ $status === 'shipping' ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => 'shipping']) }}">Shipping</a>
                    <a class="dropdown-item{{ $status === 'product-received' ? ' active' : '' }}"
                        href="{{ route('order.index', ['status' => 'product-received']) }}">Product Received</a>
                </div>
            </div>
        </form>

        <div class="filter-dashboard">
            <div class="dropdown mb-3">
                <button class="btn-filter-dashboard dropdown-toggle" type="button" id="filterDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Select Filter Option
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#" data-filter="monthYear">Filter by Month and Year</a>
                    </li>
                    <li><a class="dropdown-item" href="#" data-filter="yearOnly">Filter by Year</a></li>
                </ul>
            </div>

            <div id="filterMonthYearForm" style="display: none;" class="mb-3">
                <form action="{{ route('order.index') }}" method="GET">
                    <div class="input-group">
                        <select class="form-select" name="month" required>
                            <option value="">Select Month</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        <select class="form-select" name="year" required>
                            <option value="">Select Year</option>
                            @php
                                $currentYear = date('Y');
                                $yearRange = 3;
                                $startYear = $currentYear - $yearRange;
                                $endYear = $currentYear + $yearRange;
                            @endphp
                            @for ($year = $startYear; $year <= $endYear; $year++)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                        <input type="hidden" name="status" value="{{ $status ?? '' }}">
                        <button type="submit" class="btn-filter-dashboard">Filter</button>
                    </div>
                </form>
            </div>

            <div id="filterYearOnlyForm" style="display: none;" class="mb-3">
                <form action="{{ route('order.index') }}" method="GET">
                    <div class="input-group">
                        <select class="form-select" name="yearonly" required>
                            <option value="">Select Year</option>
                            @php
                                $currentYear = date('Y');
                                $yearRange = 3;
                                $startYear = $currentYear - $yearRange;
                                $endYear = $currentYear + $yearRange;
                            @endphp
                            @for ($yearonly = $startYear; $yearonly <= $endYear; $yearonly++)
                                <option value="{{ $yearonly }}"
                                    {{ $yearonly == $selectedYearOnly ? 'selected' : '' }}>
                                    {{ $yearonly }}
                                </option>
                            @endfor
                        </select>
                        <input type="hidden" name="status" value="{{ $status ?? '' }}">
                        <button type="submit" class="btn-filter-dashboard">Filter</button>
                    </div>
                </form>
            </div>

        </div>
        <form action="{{ route('order.index') }}" method="GET" class="ms-auto">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search orders"
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

    @if ($month && $selectedYear)
        <div class="mb-3">
            <h5>Showing orders created in: {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $selectedYear }}</h5>
        </div>
    @endif

    @if ($selectedYearOnly)
        <div class="mb-3">
            <h5>Showing orders created in: {{ $selectedYearOnly }}</h5>
        </div>
    @endif

    <div class="table-responsive" id="orderDashboard">

        <table class="table table-sm">
            <thead>
                <tr>
                    <th class="align-middle text-center" scope="col">#</th>
                    <th class="align-middle text-center" scope="col">Date of Transaction</th>
                    <th class="align-middle text-center" scope="col">Customer Name</th>
                    <th class="align-middle text-center" scope="col">Order Number</th>
                    <th class="align-middle text-center" scope="col">Orders</th>
                    @if ($status == null || $status == 'cancelled')
                        <th class="align-middle text-center" scope="col">Status</th>
                    @else
                        <th class="align-middle text-center" scope="col">Proof of Payment</th>
                    @endif
                    <th class="align-middle text-center" colspan="2" scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <div class="modal fade" id="proofModal{{ $order->id }}" tabindex="-1"
                        aria-labelledby="proofModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-image">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{ asset('storage/' . $order->proof) }}" class="img-fluid"
                                        alt="Proof of Payment">
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>

                    <tr>
                        <td class="align-middle">{{ $startIndex + $loop->index }}</td>
                        <td class="align-middle">
                            {{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d F Y') }}
                        </td>
                        <td class="align-middle">{{ $order->name }}</td>
                        <td class="align-middle">{{ $order->order_number }}</td>
                        <td class="text-left" style="max-width: 300px;">
                            <div class="my-3">
                            @foreach ($order->orderDetails->take(3) as $orderDetail)
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}"
                                        class="img-fluid mr-2" width="50">
                                    <span class="mx-2">{{ $orderDetail->merchandise->name }}
                                        <strong>({{ $orderDetail->quantity }})</strong></span>
                                </div>
                                <br>
                            @endforeach

                            @if ($order->orderDetails->count() > 3)
                                <div class="d-flex align-items-center">
                                    <span class="mx-2">and {{ $order->orderDetails->count() - 3 }} more...</span>
                                </div>
                            @endif
                            </div>
                        </td>
                        @if ($status == null)
                            <td class="align-middle">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    @if ($order->status == 1)
                                        <span class="badge bg-warning">
                                            Waiting for Payment
                                        </span>
                                    @elseif($order->status == 2)
                                        <span class="badge bg-info">
                                            Checking Payment
                                        </span>
                                    @elseif($order->status == 3)
                                        <span class="badge bg-success">
                                            Payment Success
                                        </span>
                                    @elseif($order->status == 4)
                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>
                                    @elseif($order->status == 5)
                                        <span class="badge bg-primary">
                                            Shipping
                                        </span>
                                    @elseif($order->status == 6)
                                        <span class="badge bg-primary">
                                            Product Received
                                        </span>
                                    @endif


                                    @if ($order->status != 1 && $order->proof)
                                        <button type="button" class="btn-view-dashboard mb-3 btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#proofModal{{ $order->id }}">
                                            View Proof of Payment
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @else
                            @if ($order->status != 1 && $order->proof)
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn-primary-dashboard mb-3 btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#proofModal{{ $order->id }}">
                                            View Proof of Payment
                                        </button>
                                    </div>
                                </td>
                            @elseif($order->status == 1)
                                <td class="align-middle">
                                    <span class="badge badge-warning">
                                        Waiting for Payments
                                    </span>
                                </td>
                            @elseif($order->status == 2)
                                <td class="align-middle">
                                    <span class="badge badge-info">
                                        Checking Payment
                                    </span>
                                </td>
                            @elseif($order->status == 3)
                                <td class="align-middle">
                                    <span class="badge badge-success">
                                        Payment Success
                                    </span>
                                </td>
                            @elseif($order->status == 4)
                                <td class="align-middle">
                                    <span class="badge badge-danger">
                                        Cancelled
                                    </span>
                                </td>
                            @elseif($order->status == 5)
                                <td class="align-middle">
                                    <span class="badge badge-primary">
                                        Shipping
                                    </span>
                                </td>
                            @elseif($order->status == 6)
                                <td class="align-middle">
                                    <span class="badge badge-primary">
                                        Product Received
                                    </span>
                                </td>
                            @endif
                        @endif
                        <td class="align-middle"><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </td>
                        <td class="align-middle"><a href="/admin/dashboard/orders/{{ $order->id }}"
                                class="btn-action-dashboard btn-sm me-2"><i class="fas fa-eye"></i></a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Data Empty</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
    <style>
        .modal-dialog-image {}

        .modal-dialog-image .modal-content {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .modal-dialog-image .modal-body {
            padding: 0;
        }

        .modal-dialog-image .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #000;
            opacity: 0.5;
            font-size: 1.5rem;
        }
    </style>
    <script>
        @forelse ($orders as $order)
            var myModal = new bootstrap.Modal(document.getElementById('proofModal{{ $order->id }}'));

            // Optional: Close the modal when the "Close" button is clicked
            document.getElementById('proofModal{{ $order->id }}').addEventListener('hide.bs.modal', function() {
                myModal.hide();
            });
        @empty
            // Handle empty data case, no orders to display
        @endforelse


        // Function to update the main dropdown button's text
        function updateDropdownButtonText(text) {
            $('#dropdownMenuButton').text(text);
        }

        // When a dropdown item is clicked
        $('.dropdown-item').on('click', function() {
            // Get the text of the clicked item
            var selectedText = $(this).text().trim();
            // Update the main dropdown button text
            updateDropdownButtonText(selectedText);
        });

        // On page load, update the main dropdown button's text if a status is already selected
        $(document).ready(function() {
            @if ($status)
                updateDropdownButtonText('{{ ucfirst($status) }}');
            @endif
        });
    </script>

@endsection
