@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders</h1>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="table-responsive">
    <form action="{{ route('order.index', ['status' => $status ?? '']) }}" method="GET">
        <div class="btn-group" role="group" aria-label="Filter Orders">
            <button type="submit" name="status" value=""
                class="btn btn-outline-light mb-3{{ empty($status) ? ' active' : '' }}">All</button>
            <button type="submit" name="status" value="waiting-for-payment"
                class="btn btn-outline-light mb-3{{ $status === 'waiting-for-payment' ? ' active' : '' }}">Waiting For
                Payment</button>
            <button type="submit" name="status" value="checking-payment"
                class="btn btn-outline-light mb-3{{ $status === 'checking-payment' ? ' active' : '' }}">Checking
                Payment</button>
            <button type="submit" name="status" value="success"
                class="btn btn-outline-light mb-3{{ $status === 'success' ? ' active' : '' }}">Success</button>
            <button type="submit" name="status" value="cancelled"
                class="btn btn-outline-light mb-3{{ $status === 'cancelled' ? ' active' : '' }}">Cancelled</button>
        </div>
    </form>
    <table class="table table-striped table-sm text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date of Transaction</th>
                <th scope="col">Order Number</th>
                <th scope="col">Orders</th>
                @if ($status == NULL)
                <th scope="col">Status</th>
                @else
                <th scope="col">Proof of Payment</th>
                @endif
                <th colspan="2" scope="col">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <div class="modal fade" id="proofModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="proofModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-image">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="{{ asset('storage/' . $order->proof) }}" class="img-fluid" alt="Proof of Payment">
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <tr>
                <td>{{ $startIndex + $loop->index }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d F Y') }}</td>
                <td>{{ $order->order_number }}</td>
                <td class="text-left">
                    @foreach ($order->orderDetails->take(3) as $orderDetail)
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}" class="img-fluid mr-2"
                            width="50">
                        <span class="mx-2">{{ $orderDetail->merchandise->name }}
                            <strong>({{ $orderDetail->quantity }})</strong></span>
                    </div>
                    <br>
                    @endforeach
                </td>
                @if ($status == NULL)
                <td class="align-middle">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        @if ($order->status == 1)
                        <span class="badge badge-warning">
                            Waiting for Payment
                        </span>
                        @elseif($order->status == 2)
                        <span class="badge badge-info">
                            Checking Payment
                        </span>
                        @elseif($order->status == 3)
                        <span class="badge badge-success">
                            Payment Success
                        </span>
                        @elseif($order->status == 4)
                        <span class="badge badge-danger">
                            Cancelled
                        </span>
                        @endif

                        @if ($order->status != 1 && $order->proof)
                        <button type="button" class="btn btn-outline-light mb-3 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#proofModal{{ $order->id }}">
                            View Proof of Payment
                        </button>
                        @endif
                    </div>
                </td>



                @else
                @if ($order->status != 1 && $order->proof)
                <td class="align-middle">
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-outline-light mb-3 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#proofModal{{ $order->id }}">
                            View Proof of Payment
                        </button>
                    </div>
                </td>
                @else
                <td class="align-middle">
                    <span class="badge badge-warning">
                        Waiting for Payment
                    </span>
                </td>
                @endif
                @endif
                <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                <td><a href="/admin/dashboard/orders/{{ $order->id }}" class="btn btn-sm btn-outline-light me-2"><span
                            data-feather="eye"></span></a></td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Data Empty</td>
            </tr>
            @endforelse
        <tbody>
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
    document.getElementById('proofModal{{ $order->id }}').addEventListener('hide.bs.modal', function () {
        myModal.hide();
    });
    @empty
        // Handle empty data case, no orders to display
    @endforelse
</script>

@endsection