@extends('dashboard.layouts.main')
@section('content')


<div id="showOrder">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Order Details</h1>
    </div>
    <a href="{{ route('order.index') }}" class="btn btn-transparent me-2 my-3">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left" class="me-1"></span>
            Back to Orders</div>
    </a>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-4">Order Information
                @if ($order->status == 1)
                <span class="badge bg-warning">Waiting for Payment</span>
                @elseif ($order->status == 2)
                <span class="badge bg-info">Checking Payment</span>
                @elseif ($order->status == 3)
                <span class="badge bg-info">Payment Success</span>
                @elseif ($order->status == 4)
                <span class="badge bg-danger">Cancelled</span>
                @elseif ($order->status == 5)
                <span class="badge bg-warning">Shipping</span>
                @elseif ($order->status == 6)
                <span class="badge bg-success">Product Received</span>
                @endif
            </h3>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Order Number</td>
                        <td>: {{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td>Date of Transaction</td>
                        <td>: {{ $order->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: 
                            @if ($order->status == 1)
                            Waiting for Payment
                            @elseif ($order->status == 2)
                            Checking Payment
                            @elseif ($order->status == 3)
                            Payment Success
                            @elseif ($order->status == 4)
                            Cancelled
                            @elseif ($order->status == 5)
                            Shipping
                            @elseif ($order->status == 6)
                            Product Received
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Total Order Cost</td>
                        <td>: Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Shipping fee</td>
                        <td>: Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Cost (Order + Shipping)</strong></td>
                        <td><strong>
                                Rp {{ number_format($order->total_price + $order->shipping_fee, 0, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">User Information</h3>
            <p><strong>User Name:</strong> {{ $order->user->name }}</p>
            <p><strong>User Email:</strong> {{ $order->user->email }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Order Items</h3>
            <table class="table">
                <tbody>
                    @foreach ($order->orderDetails as $orderDetail)
                        <tr>
                            @if ($orderDetail->merchandise)
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}" class="img-fluid mr-2" width="70">
                                </div>
                            </td>
                            <td class="align-middle">{{ $orderDetail->merchandise->name }}</td>
                            @else
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="{{ url('./assets/img/icons/question-mark-29.svg') }}" class="img-fluid mr-2" width="70" style="filter: brightness(0) invert(1);">
                                </div>
                            </td>
                            <td class="align-middle fst-italic">Unknown item</td>
                            @endif
                            <td class="align-middle">(Quantity: {{ $orderDetail->quantity }})</td>
                        </tr>
                    @endforeach
                            
                </tbody>
            </table>
            
        </div>
    </div>

    <div class="card my-4 mb-5">
        <div class="card-body">
            <h3 class="card-title mb-4">
                Shipping Information
            </h3>
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Recipient Name</strong></td>
                        <td>: {{ $order->name }}</td>
                    </tr>

                    @if ($order->province_id)
                    <tr>
                        <td><strong>Province</strong></td>
                        <td>: {{ $order->province->title }}</td>
                    </tr>
                    @endif
                    @if ($order->city_id)
                    <tr>
                        <td><strong>City</strong></td>
                        <td>: {{ $order->city->title }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Full Address</strong></td>
                        <td>: {{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Postal Code</strong></td>
                        <td>: {{ $order->postal_code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number</strong></td>
                        <td>: {{ $order->phone_number }}</td>
                    </tr>
                </tbody>
            </table>
            

        </div>
    </div>
    @if ($order->proof)
    <div class="card my-4 mb-5">
        <div class="card-body text-center">
            <h3 class="card-title mb-4">
                Proof Of Payment
            </h3>
            <img src="{{ asset('storage/' . $order->proof) }}" class="img-fluid" alt="Proof of Payment">
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