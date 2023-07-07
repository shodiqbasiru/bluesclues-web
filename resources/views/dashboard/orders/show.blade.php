@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Order Details</h1>
</div>
<a href="/admin/dashboard/orders" class="btn btn-transparent me-2 my-3">
    <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
            class="me-1"></span> Back to Orders</div>
</a>

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
                <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}" class="img-fluid mr-2" width="50">
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
@endsection
