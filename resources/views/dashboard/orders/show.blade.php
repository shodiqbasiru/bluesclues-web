@extends('dashboard.layouts.main')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Order Details</h1>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-transparent me-2 my-3">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left" class="me-1"></span>
            Back to Orders</div>
    </a>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div id="showOrder">

        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-4">Order Information</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Date of Transaction:</strong> {{ $order->created_at->format('d F Y') }}</p>
                <p><strong>Status:</strong>
                    @if ($order->status == 1)
                        <span class="badge badge-warning">Waiting for Payment</span>
                    @elseif ($order->status == 2)
                        <span class="badge badge-info">Checking Payment</span>
                    @elseif ($order->status == 3)
                        <span class="badge badge-success">Payment Success</span>
                    @elseif ($order->status == 4)
                        <span class="badge badge-danger">Cancelled</span>
                    @elseif ($order->status == 5)
                        <span class="badge badge-danger">Shipping</span>
                    @elseif ($order->status == 6)
                        <span class="badge badge-danger">Product Received</span>
                    @endif
                </p>
                <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <h3 class="card-title mb-4">User Information</h3>
                <p><strong>User Name:</strong> {{ $order->user->name }}</p>
                <p><strong>User Email:</strong> {{ $order->user->email }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h3 class="card-title mb-4">Order Items</h3>
                @foreach ($order->orderDetails as $orderDetail)
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}" class="img-fluid mr-2"
                            width="50">
                        <span>{{ $orderDetail->merchandise->name }}</span>
                        <span class="mx-2">(Quantity: {{ $orderDetail->quantity }})</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card my-4 mb-5">
            <div class="card-body">
                <h3 class="card-title mb-4">
                    Shipping Information
                </h3>
                <p><strong>Recipient Name:</strong> {{ $order->name }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>Postal Code:</strong> {{ $order->postal_code }}</p>
                <p><strong>Phone Number:</strong> {{ $order->phone_number }}</p>

            </div>
        </div>
        @if ($order->proof)
            <div class="modal fade justify-content-center" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="{{ asset('storage/' . $order->proof) }}" class="img-fluid" alt="Proof of Payment">
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>


            <div class="card my-4 mb-5">
                <div class="card-body">
                    <h3 class="card-title mb-4">
                        Proof Of Payment
                    </h3>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="btn-primary-dashboard mb-3 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#proofModal">
                            View Proof of Payment
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if ($order->status == 2)
            <div class="d-flex align-items-center justify-content-center">
                <form action="{{ route('order.confirm', $order->id) }}" method="post">
                    @csrf
                    <button type="submit" onclick="return confirm ('Are you sure to confirm this order?')"
                        class="btn-primary-dashboard mb-3 btn-sm">Confirm Payment</button>
            </div>
        @elseif ($order->status == 3)
            <div class="d-flex align-items-center justify-content-center">
                <form action="{{ route('order.shipping', $order->id) }}" method="post">
                    @csrf
                    <button type="submit" onclick="return confirm ('Are you sure you want to ship this order?')"
                        class="btn-primary-dashboard mb-3 btn-sm">Ship Order</button>
                </form>
            </div>
        @endif

    </div>
@endsection
